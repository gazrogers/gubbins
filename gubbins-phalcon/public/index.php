<?php
/**
 * Application entry point - sets up the application and outputs the response content
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL ^ E_DEPRECATED);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle($_GET['_url'])->getContent();
} catch (\Exception $e) {
    $error =  $e->getMessage() . "\n";
    $error .= $e->getTraceAsString();
    $logger = $di->get('logger');
    $logger->error($error);
}
