<?php

use App\Repository\ContactRepository;
use App\Repository\EventRepository;
use App\Repository\GroupRepository;
use App\Repository\LocationRepository;
use App\Repository\StreamRepository;
use App\Repository\TrophyRepository;
use App\Repository\UserRepository;
use Slim\Container;

$container = $app->getContainer();

/**
 * User Repository container.
 *
 * @param Container $container
 * @return UserRepository
 */
$container[UserRepository::class] = function (Container $container) {
    return new UserRepository($container);
};

/**
 * Trophy Repository container.
 *
 * @param Container $container
 * @return TrophyRepository
 */
$container[TrophyRepository::class] = function (Container $container) {
    return new TrophyRepository($container);
};

/**
 * Trophy Group Repository container.
 *
 * @param Container $container
 * @return GroupRepository */
$container[GroupRepository::class] = function (Container $container) {
    return new GroupRepository($container);
};

/**
 * Trophy Stream Repository container.
 *
 * @param Container $container
 * @return StreamRepository */
$container[StreamRepository::class] = function (Container $container) {
    return new StreamRepository($container);
};

/**
 * Trophy Contact Repository container.
 *
 * @param Container $container
 * @return ContactRepository */
$container[ContactRepository::class] = function (Container $container) {
    return new ContactRepository($container);
};

/**
 * Trophy Location Repository container.
 *
 * @param Container $container
 * @return LocationRepository */
$container[LocationRepository::class] = function (Container $container) {
    return new LocationRepository($container);
};

/**
 * Trophy Event Repository container.
 *
 * @param Container $container
 * @return EventRepository */
$container[EventRepository::class] = function (Container $container) {
    return new EventRepository($container);
};
