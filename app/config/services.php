<?php

use Phalcon\Mvc\View;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Session as Flash;
use Phalcon\Mvc\View\Engine\Volt;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

$di->setShared('router', function () {
    return include APP_PATH . "/config/router.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ]);


            $compiler = $volt->getCompiler();
            $compiler->addFunction('format_date', function($resolvedArgs, $exprArgs) {
                return 'date(\'j F Y H:i\', strtotime('. $resolvedArgs .'))';
            });
            $compiler->addFunction('short_body', function($resolvedArgs, $exprArgs) {
                return '
                strip_tags(
                    trim(
                        preg_replace("/<p>/", " ", substr(' . $resolvedArgs . ', 0, 300))
                    )
                )';
            });
            $compiler->addFunction('createTitleSlug', function($resolvedArgs, $exprArgs) {
                return 'str_replace(" ", "-", preg_replace("/\s{2,}/", " ", preg_replace("/[^a-z0-9 ]+/", "", trim(strtolower('. $resolvedArgs .')))))';
            });
            $compiler->addFunction('niceNumber', function($resolvedArgs, $exprArgs) {
                return 'number_format(' .$resolvedArgs .')';
            });

            return $volt;

        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
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

    return $connection;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert is-error',
        'success' => 'alert is-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/*
 * Cookie set code
 */
$di->set(
    'cookies',
    function () {
        $cookies = new Cookies();

        $cookies->useEncryption(false);

        return $cookies;
    }
);

/**
 *  Setting up the login details for sendinblue with SwiftMailer
 */
$di->set('phpmailer', function () {

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = $_ENV['EMAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['EMAIL_USER'];
    $mail->Password = $_ENV['EMAIL_PASS'];
    $mail->SMTPSecure = 'tls';
    $mail->Port = $_ENV['EMAIL_PORT'];

    return $mail;
});

/**
 *  Settings I can use in controllers
 */
$di->set('appName', function () {
    return $_ENV['APP_NAME'];
});

$di->set('appURL', function () {
    return $_ENV['APP_URL'];
});