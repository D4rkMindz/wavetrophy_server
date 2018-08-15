<?php

use App\Table\AddressImageTable;
use App\Table\AddressTable;
use App\Table\CarTable;
use App\Table\ContactTable;
use App\Table\EventImageTable;
use App\Table\EventTable;
use App\Table\GroupTable;
use App\Table\ImageTable;
use App\Table\PermissionTable;
use App\Table\TeamTable;
use App\Table\TrophyTable;
use App\Table\UserTable;
use Cake\Database\Connection;
use Slim\Container;

$container = $app->getContainer();

/**
 * AddressImageTable container.
 *
 * @param Container $container
 * @return AddressImageTable
 */
$container[AddressImageTable::class] = function (Container $container) {
    return new AddressImageTable($container->get(Connection::class));
};

/**
 * AddressTable container.
 *
 * @param Container $container
 * @return AddressTable
 */
$container[AddressTable::class] = function (Container $container) {
    return new AddressTable($container->get(Connection::class));
};

/**
 * CarTable container.
 *
 * @param Container $container
 * @return CarTable
 */
$container[CarTable::class] = function (Container $container) {
    return new CarTable($container->get(Connection::class));
};

/**
 * ContactTable container.
 *
 * @param Container $container
 * @return ContactTable
 */
$container[ContactTable::class] = function (Container $container) {
    return new ContactTable($container->get(Connection::class));
};

/**
 * EventImageTable container.
 *
 * @param Container $container
 * @return EventImageTable
 */
$container[EventImageTable::class] = function (Container $container) {
    return new EventImageTable($container->get(Connection::class));
};

/**
 * EventTable container.
 *
 * @param Container $container
 * @return EventTable
 */
$container[EventTable::class] = function (Container $container) {
    return new EventTable($container->get(Connection::class));
};

/**
 * GroupTable container.
 *
 * @param Container $container
 * @return GroupTable
 */
$container[GroupTable::class] = function (Container $container) {
    return new GroupTable($container->get(Connection::class));
};

/**
 * ImageTable container.
 *
 * @param Container $container
 * @return ImageTable
 */
$container[ImageTable::class] = function (Container $container) {
    return new ImageTable($container->get(Connection::class));
};

/**
 * PermissionTable container.
 *
 * @param Container $container
 * @return PermissionTable
 */
$container[PermissionTable::class] = function (Container $container) {
    return new PermissionTable($container->get(Connection::class));
};

/**
 * TeamTable container.
 *
 * @param Container $container
 * @return TeamTable
 */
$container[TeamTable::class] = function (Container $container) {
    return new TeamTable($container->get(Connection::class));
};

/**
 * TrophyTable container.
 *
 * @param Container $container
 * @return TrophyTable
 */
$container[TrophyTable::class] = function (Container $container) {
    return new TrophyTable($container->get(Connection::class));
};
/**
 * UserTable container.
 *
 * @param Container $container
 * @return UserTable
 */
$container[UserTable::class] = function (Container $container) {
    return new UserTable($container->get(Connection::class));
};
