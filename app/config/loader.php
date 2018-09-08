<?php

$loader = new \Phalcon\Loader();

/**
 * Register directories for the Phalcon autoloader
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
);

/**
 * Register Files, composer autoloader
 */
$loader->registerFiles(
    [
        APP_PATH . '/library/vendor/autoload.php'
    ]
);

/**
 * Register API v1 namespace
 */
$loader->registerNamespaces(
    [
        'Api\v1' => $config->application->controllersDir . '/api/v1',
    ]
);

/**
 * Register Autoloader
 */
$loader->register();