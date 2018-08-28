<?php
$app->get('/', 'App\Controller\IndexController:indexAction')->setName('api.get.root');

/**
 * Auth
 */
$app->post('/v1/auth', 'App\Controller\AuthenticationController:authenticateAction')->setName('api.post.v1.auth');

$app->post('/v1/upload/image', 'App\Controller\UploadController:uploadImageAction')->setName('api.post.v1.upload.image');

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

$app->get('/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}/locations', route(['App\Controller\LocationController', 'getAllLocationsAction']))->setName('api.get.v1.trophies.single.groups.single.locations');
// todo test
$app->post('/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}/locations', route(['App\Controller\LocationController', 'createLocationAction']))->setName('api.post.v1.trophies.single.groups.single.locations');
// todo test
$app->delete('/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}/locations/{location_hash}', route(['App\Controller\LocationController', 'deleteLocationAction']))->setName('api.delete.v1.trophies.single.groups.single.locations');

// todo test
$app->post('/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}/locations/{location_hash}/events', route(['App\Controller\EventController', 'createEventAction']))->setName('api.post.v1.trophies.single.groups.single.locations.single.events');
// todo test
$app->delete('/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}/locations/{location_hash}/events/{event_hash}', route(['App\Controller\EventController', 'deleteEventAction']))->setName('api.delete.v1.trophies.single.groups.single.locations.single.events');

// todo test
$app->post('/v1/trophies/{wavetrophy_hash}/groups', route(['App\Controller\GroupController', 'createGroupAction']))->setName('api.post.v1.trophies.single.groups');
// todo test
$app->put('/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}', 'App\Controller\GroupController:updateGroupAction')->setName('api.put.v1.trophies.single.groups.single');

$app->delete('/v1/trophies/{wavetrophy_hash}/groups/{road_group_hash}', 'App\Controller\GroupController:deleteGroupAction')->setName('api.delete.v1.trophies.single.groups.single');

/**
 * Get contacts for WaveTrophy
 */
$app->get('/v1/trophies/{wavetrophy_hash}/contacts', route(['App\Controller\ContactController', 'getContactsAction']))->setName('api.get.v1.trophies.single.contacts');

// todo test
$app->post('/v1/trophies/{wavetrophy_hash}/contacts', route(['App\Controller\ContactController', 'createContactAction']))->setName('api.post.v1.trophies.single.contacts');