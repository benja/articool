<?php
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

/**
 * Using values from .env
 */
require BASE_PATH . '/app/library/vendor/autoload.php'; 
$dotenv = new \Dotenv\Dotenv(BASE_PATH); 
$dotenv->load();

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => $_ENV['DATABASE_HOST'],
        'username'    => $_ENV['DATABASE_USER'],
        'password'    => $_ENV['DATABASE_PASS'],
        'dbname'      => $_ENV['DATABASE_NAME'],
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => $_ENV['APP_DIR'],
    ]
]);