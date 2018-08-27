<?php

$config = [];

$applicationName = 'app_template';

$config = [
    'displayErrorDetails' => false,
    'determineRouteBeforeAppMiddleware' => true,
    'addContentLengthHeader' => false,
    'enableCORS' => false,
    'isProduction' => true,
    'debug' => false,
];

$config['migrations'] = __DIR__ . '/../resources/migrations';

$config['jwt'] = [
    'active' => false,
    'secret' => '',
    'passthrough' => [
        '/' => ['GET'],
        '/v1/auth' => ['POST'],
        '/v1/trophies' => ['GET'],
        '/v1/trophies/{wavetrophy_hash}' => ['GET'],
        '/v1/trophies/{wavetrophy_hash}/groups' => ['GET'],
        '/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}' => ['GET'],
        '/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}/stream' => ['GET'],
        '/v1/trophies/{wavetrophy_hash}/contacts' => ['GET'],
    ]
];

// used in Role::checkAllowedRoutes (also allowes placeholder user_id, other placeholders must be created)
$config['allowedPaths'] = [
    ['path' => '/v2/users/{user_id}', 'methods' => ['GET', 'POST', 'PUT', 'DELETE'],],
    ['path' => '/v2/departmentgroups', 'methods' => ['GET'],],
    ['path' => '/v2/cities', 'methods' => ['GET'],],
    ['path' => '/v2/events', 'methods' => ['GET'],],
    ['path' => '/v2/user-error', 'methods' => ['GET'],],
];

$config['db'] = [
    'database' => 'wavetrophy',
    'charset' => 'utf8',
    'encoding' => 'utf8',
    'collation' => 'utf8_unicode_ci',
];

$config['language_whitelist'] = [
    'de' => 'de_CH',
    'en' => 'en_GB',
    'fr' => 'fr_CH',
    'it' => 'it_CH',
];

$config['mailgun'] = [
    'from' => '',
    'apikey' => '',
    'domain' => '',
];

// used to render email templates
$config['twig'] = [
    'viewPath' => __DIR__ . '/../template',
    'cachePath' => __DIR__ . '/../tmp/cache/twig',
    'autoReload' => false,
];

$config['logger'] = [
    'logDir' => __DIR__  . '/../tmp/logs',
];

return $config;