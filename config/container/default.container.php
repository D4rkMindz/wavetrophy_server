<?php

use App\Service\Image\ImageHandler;
use App\Service\Login\LoginValidation;
use App\Service\Validation\ContactValidation;
use App\Service\Validation\EventValidation;
use App\Service\Validation\GroupValidation;
use App\Service\Validation\LocationValidation;
use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Odan\Twig\TwigAssetsExtension;
use Odan\Twig\TwigTranslationExtension;
use Slim\Container;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

$container = $app->getContainer();

/**
 * Environment container (for routes).
 *
 * @return Environment
 */
$container['environment'] = function (): Environment {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $_SERVER['SCRIPT_NAME'] = dirname(dirname($scriptName)) . '/' . basename($scriptName);

    return new Slim\Http\Environment($_SERVER);
};

/**
 * Twig container.
 *
 * @param Container $container
 * @return Twig
 */
$container[Twig::class] = function (Container $container): Twig {
    $twigSettings = $container->get('settings')->get('twig');

    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');

    $twig = new Twig($twigSettings['viewPath'],
        ['cache' => $twigSettings['cachePath'], 'auto_reload' => $twigSettings['autoReload']]);
    $twig->addExtension(new TwigTranslationExtension());
    $twig->addExtension(new \Slim\Views\TwigExtension($container->get('router'), $basePath));
    $twig->addExtension(new TwigAssetsExtension($twig->getEnvironment(), $twigSettings['assetCache']));

    return $twig;
};

/**
 * Translator container.
 *
 * @param Container $container
 * @return Translator $translator
 */
$container[Translator::class] = function (Container $container): Translator {
    $settings = $container->get('settings')->get(Translator::class);
    $translator = new Translator($settings['locale'], /** @scrutinizer ignore-type */
        new MessageSelector());
    $translator->addLoader('mo', new MoFileLoader());

    return $translator;
};

/**
 * Database connection container.
 *
 * @param Container $container
 * @return Connection
 */
$container[Connection::class] = function (Container $container): Connection {
    $config = $container->get('settings')->get('db');
    $driver = new Mysql([
        'host' => $config['host'],
        'port' => $config['port'],
        'database' => $config['database'],
        'username' => $config['username'],
        'password' => $config['password'],
        'encoding' => $config['encoding'],
        'charset' => $config['charset'],
        'collation' => $config['collation'],
        'prefix' => '',
        'flags' => [
            // Enable exceptions
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Set default fetch mode
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8 COLLATE utf8_unicode_ci",
        ],
    ]);
    $db = new Connection([
        'driver' => $driver,
    ]);

    $db->connect();

    return $db;
};

/**
 * Contact Validation container.
 *
 * @param Container $container
 * @return ContactValidation
 */
$container[ContactValidation::class] = function (Container $container): ContactValidation {
    return new ContactValidation($container);
};

/**
 * Location Validation container.
 *
 * @param Container $container
 * @return LocationValidation
 */
$container[LocationValidation::class] = function (Container $container): LocationValidation {
    return new LocationValidation($container);
};;

/**
 * Login Validation container.
 *
 * @param Container $container
 * @return LoginValidation
 */
$container[LoginValidation::class] = function (Container $container): LoginValidation {
    return new LoginValidation($container);
};

/**
 * Image handler container.
 *
 * @param Container $container
 * @return ImageHandler
 */
$container[ImageHandler::class] = function (Container $container): ImageHandler {
    return new ImageHandler();
};

/**
 * Event Validation container.
 *
 * @param Container $container
 * @return EventValidation
 */
$container[EventValidation::class] = function (Container $container): EventValidation {
    return new EventValidation($container);
};

/**
 * Group Validation container.
 *
 * @param Container $container
 * @return GroupValidation
 */
$container[GroupValidation::class] = function (Container $container): GroupValidation {
    return new GroupValidation($container);
};

/**
 * Logger container.
 *
 * @param Container $container
 * @return Logger
 */
$container[Monolog\Logger::class] = function (Container $container) {
    $fileName = $container->get('settings')->get('logger')['logDir'] . '/' . date('Y-m-d'). '_request.log';
    $handler = new RotatingFileHandler($fileName);
    return new Logger('app', [$handler]);
};

/**
 * Request Logger container.
 *
 * @param Container $container
 * @return Logger
 */
$container[Monolog\Logger::class . '_request'] = function (Container $container) {
    $fileName = $container->get('settings')->get('logger')['logDir'] . '/' . date('Y-m-d'). '_request.log';
    $handler = new RotatingFileHandler($fileName);
    return new Logger('app.request', [$handler]);
};

/**
 * Not found handler.
 *
 * @param Container $container
 * @return Closure
 */
$container['notFoundHandler'] = function (Container $container) {
    return function (Request $request, Response $response) use ($container) {
        return $response->withRedirect($container->get('router')->pathFor('notFound', ['language' => 'en']));
    };
};