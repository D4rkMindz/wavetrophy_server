<?php

use App\Repository\GroupRepository;
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
 * Trohpy Repository container.
 *
 * @param Container $container
 * @return TrophyRepository
 */
$container[TrophyRepository::class] = function (Container $container) {
    return new TrophyRepository($container);
};

/**
 * Trohpy Group Repository container.
 *
 * @param Container $container
 * @return GroupRepository
 */
$container[GroupRepository::class] = function (Container $container) {
    return new GroupRepository($container);
};
