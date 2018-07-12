<?php
//$language = '{language:(?:de|en)}';

//$app->get('/[' . $language . ']', 'App\Controller\IndexController:homeAction')->setName('root');
//$app->get('/' . $language . '/error', 'App\Controller\ErrorController:notFoundAction')->setName('notFound');
//$app->get('/' . $language . '/login', 'App\Controller\UserController:loginAction')->setName('get.login');
//$app->get('/' . $language . '/logout', 'App\Controller\API\AuthenticationController:logoutAction')->setName('get.logout');
//$app->get('/' . $language . '/landingpage', 'App\Controller\IndexController:landingpageAction')->setName('get.landingpage');
//$app->get('/' . $language . '/register', 'App\Controller\UserController:registerAction')->setName('get.register');
//$app->get('/' . $language . '/home', 'App\Controller\IndexController:homeAction')->setName('get.home');

//$app->get('/' . $language . '/trophies', 'App\Controller\IndexController:homeAction')->setName('get.trophies');
//$app->get('/' . $language . '/trophies/create', 'App\Controller\IndexController:homeAction')->setName('get.trophies.create');

//$app->get('/' . $language . '/users', 'App\Controller\IndexController:homeAction')->setName('get.users');
//$app->get('/' . $language . '/users/create', 'App\Controller\IndexController:homeAction')->setName('get.users.create');

$app->get('/', 'App\Controller\API\ApiController:indexAction')->setName('api.get.root');
$app->post('/v1/auth', 'App\Controller\API\AuthenticationController:authenticateAction')->setName('api.post.v1.auth');
//$app->get('/api/home', 'App\Controller\ApiController:redirectToHomeAction')->setName('api.to-home');