<?php

/**
 * Authentication route
 */
$app->post('/v2/auth', route(['App\Controller\AuthenticationController', 'authenticateAction']))->setName('api.post.auth');

/***********************************************************************************************************************
 * Users routes
 */
$app->get('/v2/users', route(['App\Controller\UserController', 'getAllUsersAction']))->setName('api.get.users');
$app->post('/v2/users/signup', route(['App\Controller\UserController', 'signupAction']))->setName('api.post.users.signup');
$app->post('/v2/users/verify', route(['App\Controller\UserController', 'verifyEmailAction']))->setName('api.post.users.verify');