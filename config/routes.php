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
$app->get('/v1/trophies/{wavetrophy_hash}', 'App\Controller\TrophyController:getTrophyAction')->setName('api.get.v1.trophies.single');

/**
 * Get all groups
 */
$app->get('/v1/trophies/{wavetrophy_hash}/groups', 'App\Controller\GroupController:getGroupsAction')->setName('api.get.v1.trophies.single.groups');
$app->get('/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}', 'App\Controller\GroupController:getGroupAction')->setName('api.get.v1.trophies.single.groups.single');

/**
 * Get stream of groups
 */
$app->get('/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}/stream', route(['App\Controller\StreamController', 'getStreamAction']))->setName('api.get.v1.trophies.single.groups.single.stream');

// todo test
$app->post('/v1/trophies/{wavetrophy_hash}/groups/{road_group_has}/locations', route(['App\Controller\LocationController', 'createLocationAction']))->setName('api.post.v1.trophies.single.locations');

// TODO continue here 20 8 2018
$app->post('/v1/trophies/{wavetrophy_hash}/groups/{road_group_has}/locations/{location_hash}/events', route(['App\Controller\EventController', 'createEventAction']))->setName('api.post.v1.trophies.single.locations.single.events');

/**
 * Get contacts for WaveTrophy
 */
$app->get('/v1/trophies/{wavetrophy_hash}/contacts', route(['App\Controller\ContactController', 'getContactsAction']))->setName('api.get.v1.trophies.single.contacts');

$app->post('/v1/trophies/{wavetrophy_hash}/contacts', route(['App\Controller\ContactController', 'createContactAction']))->setName('api.post.v1.trophies.single.contacts');