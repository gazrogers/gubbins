<?php
/**
 * Register namespaces for autoloading
 * 
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Autoload\Loader();

$loader->setNamespaces(
    [
        'Controller'     => $config->application->controllersDir,
        'Library'        => $config->application->libraryDir,
        'Model'          => $config->application->modelsDir,
        'Plugins'        => $config->application->pluginsDir
    ]
)->register();

/**
 * Add the Composer autoloader
 */
if(file_exists(BASE_PATH . '/vendor/autoload.php'))
{
    require_once BASE_PATH . '/vendor/autoload.php';
}
