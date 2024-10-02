<?php
/**
 * Register application services in the DI container
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

declare(strict_types=1);

use Phalcon\Cache\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Flash\Session as Flash;
use Phalcon\Html\Escaper;
use Phalcon\Logger\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Mvc\Url as UrlResolver;
use Plugins\ErrorHandler;
use Plugins\SecurityPlugin;

/**
 * Shared configuration service
 */
$di->setShared(
    'config',
    function () {
        return include APP_PATH . "/config/config.php";
    }
);

/**
 * Registering a dispatcher
 */
$di->set(
    'dispatcher',
    function () {
        $eventsManager = new EventsManager();
        // $eventsManager->attach(
        //     'dispatch:beforeExecuteRoute',
        //     new SecurityPlugin()
        // );
        // $eventsManager->attach(
        //     'dispatch:beforeException',
        //     new ErrorHandler()
        // );

        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace('Controller');
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared(
    'url',
    function () {
        $config = $this->getConfig();

        $url = new UrlResolver();
        $url->setBaseUri($config->application->baseUri);

        return $url;
    }
);

/**
 * Setting up the view component
 */
$di->setShared(
    'view',
    function () {
        $config = $this->getConfig();

        $view = new View();
        $view->setDI($this);
        $view->setViewsDir($config->application->viewsDir);

        $view->registerEngines([
            '.volt' => function ($view) {
                $config = $this->getConfig();

                $volt = new VoltEngine($view, $this);

                $volt->setOptions([
                    'path' => $config->application->cacheDir . 'views/',
                    'separator' => '_'
                ]);

                return $volt;
            },
            '.phtml' => PhpEngine::class

        ]);

        return $view;
    }
);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared(
    'db',
    function () {
        $config = $this->getConfig();

        $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
        $params = [
            'host'     => $config->database->host,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname'   => $config->database->dbname,
            'charset'  => $config->database->charset
        ];

        if ($config->database->adapter == 'Postgresql') {
            unset($params['charset']);
        }

        $connection = new $class($params);

        if($config->logSql)
        {
            $logger = new Logger(
                'sql',
                [
                    'main' => new Stream($config->application->logsDir . 'sql.log')
                ]
            );
            $eventsManager = new EventsManager();
            $eventsManager->attach('db', function($event, $connection) use ($logger) {
                if($event->getType() === "beforeQuery")
                {
                    $logger->debug(
                        var_export($connection->getSQLStatement(), true)
                        . "\n\n"
                        . var_export($connection->getSQLVariables(), true)
                    );
                }
                switch($event->getType())
                {
                    case "afterConnect":
                    case "beforeDisconnect":
                    case "beginTransaction":
                    case "rollbackTransaction":
                    case "commitTransaction":
                        $logger->debug($event->getType());
                        break;
                    default:
                        break;
                }
            });
            $connection->setEventsManager($eventsManager);
        }

        return $connection;
    }
);

/**
 * Register the logging service
 *
 * If in the dev-env, log to application.log, otherwise log to stderr
 */
$di->set(
    'logger',
    function () {
        $config = $this->getConfig();
        return new Logger(
            'messages',
            [
                'main' => getenv('STREAMLOGS') ? new Stream('php://stderr') : new Stream($config->application->logsDir . 'application.log')
            ]
        );
    }
);

$di->set(
    'modelsCache',
    function () {
        $config = $this->getConfig();
        $serializerFactory = new SerializerFactory();
        $adapterFactory    = new AdapterFactory($serializerFactory);

        $options = [
            'defaultSerializer' => 'Php',
            'lifetime'          => $config->caching->expiry->models,
            'storageDir'        => $config->application->cacheDir . 'responses',
        ];

        $adapter = $adapterFactory->newInstance('stream', $options);

        return new Cache($adapter);
    }
);

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared(
    'modelsMetadata',
    function () {
        return new MetaDataAdapter();
    }
);

/**
 * Start the session the first time some component request the session service
 */
$di->setShared(
    'session',
    function () {
        $session = new SessionManager();
        $files = new SessionAdapter([
            'savePath' => sys_get_temp_dir(),
        ]);
        $session->setAdapter($files);
        $session->start();

        return $session;
    }
);

/**
 * Application version
 */
$di->setShared(
    'version',
    function() {
        $composerInfo = json_decode(file_get_contents(BASE_PATH . "/composer.json"), true);
        return $composerInfo['version'];
    }
);
