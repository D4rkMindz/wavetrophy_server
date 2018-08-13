<?php
$app->get('/', 'App\Controller\IndexController:indexAction')->setName('api.get.root');

/**
 * Auth
 */
$app->post('/v1/auth', 'App\Controller\AuthenticationController:authenticateAction')->setName('api.post.v1.auth');

/**
 * Trophies
 */
$app->get('/v1/trophies', 'App\Controller\TrophyController:getTrophiesAction')->setName('api.get.v1.trophies');
$app->get('/v1/trophies/{trophy_hash}', 'App\Controller\TrophyController:getTrophyAction')->setName('api.get.v1.trophies.single');

/**
 * Get all groups
 */
$app->get('/v1/trophies/{trophy_hash}/groups', 'App\Controller\GroupController:getGroupsAction')->setName('api.get.v1.trophies.single.groups');
$app->get('/v1/trophies/{trophy_hash}/groups/{group_hash}', 'App\Controller\GroupController:getGroupAction')->setName('api.get.v1.trophies.single.groups.single');

/**
 * Get stream of groups
 */
$app->get('/v1/wave/{trophy_hash}/groups/{group_hash}/stream', route(['App\Controller\StreamController', 'indexAction']))->setName('api.get.v1.trophies.single.groups.single.stream');