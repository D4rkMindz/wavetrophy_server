<?php

use Slim\App;
use Symfony\Component\Translation\Translator;

require_once __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../config/config.php';

$app = new App(['settings' => $settings]);

// Set up dependencies
require __DIR__ . '/../config/container/container.php';

// Register routes
require __DIR__ . '/../config/routes.php';

// Set App
__($app->getContainer()->get(Translator::class));

// Load Middleware
require __DIR__ . '/../config/middleware.php';

return $app;
