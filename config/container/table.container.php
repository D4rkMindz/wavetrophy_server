<?php

use App\Table\UserTable;
use Cake\Database\Connection;
use Slim\Container;

$container = $app->getContainer();

/**
 * UserTable container.
 *
 * @param Container $container
 * @return UserTable
 */
$container[UserTable::class] = function (Container $container) {
    return new UserTable($container->get(Connection::class));
};