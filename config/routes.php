<?php
$app->get('/', 'App\Controller\IndexController:indexAction')->setName('api.get.root');
$app->post('/v1/auth', 'App\Controller\AuthenticationController:authenticateAction')->setName('api.post.v1.auth');
$app->get('/v1/trophies', 'App\Controller\TrophyController:getTrophiesAction')->setName('api.get.v1.trophies');
$app->get('/v1/trophies/{trophy_hash}', 'App\Controller\TrophyController:getTrophyAction')->setName('api.get.v1.trophies.single');