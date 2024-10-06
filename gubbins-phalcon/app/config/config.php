<?php
/**
 * Application configuration
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config\Config(
    [
        'database' => [
            'adapter'    => 'Mysql',
            'charset'    => 'utf8mb4',
            'host'       => getenv('DB_HOST'),
            'username'   => getenv('DB_USER'),
            'password'   => getenv('DB_PASSWORD'),
            'dbname'     => (php_sapi_name() === 'cli' ? 'autotests' : getenv('DB_PREFIX')) . '_gubbins',
        ],
        'application' => [
            'appDir'         => APP_PATH . '/',
            'controllersDir' => APP_PATH . '/controllers/',
            'modelsDir'      => APP_PATH . '/models/',
            'migrationsDir'  => APP_PATH . '/migrations/',
            'viewsDir'       => APP_PATH . '/views/',
            'pluginsDir'     => APP_PATH . '/plugins/',
            'libraryDir'     => APP_PATH . '/library/',
            'logsDir'        => APP_PATH . '/logs/',
            'cacheDir'       => BASE_PATH . '/cache/',
            'baseUri'        => '/gubbins',
        ],
        'caching' => [
            'expiry' => [
                'models' => 7200,
            ]
        ],
        "credentials" => [
            "GOOGLE_CLIENT_ID" => getenv('GOOGLE_CLIENT_ID'),
            "GOOGLE_CLIENT_SECRET" => getenv('GOOGLE_CLIENT_SECRET')
        ],
        'logSql' => false
    ]
);
