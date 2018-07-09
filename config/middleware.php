<?php

use Aura\Session\Session;
use Slim\Http\Request;
use Slim\Http\Response;
use Symfony\Component\Translation\Translator;

$container = $app->getContainer();

$app->add(function (Request $request, Response $response, $next) use ($container) {
    // check request comes from mobile app
    if (isRequestedFromMobileApp($request)) {
        // TODO add auth for mobile
        return $next($request, $response);
    }

    // check if requested route is public
    $allowedRoutes = $container->get('settings')->get('allowed_routes');
    $requestTarget = $request->getRequestTarget();
    $route = $request->getAttribute('route')->getName();
    if (in_array($route, $allowedRoutes)) {
        return $next($request, $response);
    }

    // check if user is logged in
    $sessionHandler = $container->get(Session::class);
    $session = $sessionHandler->getSegment('app');
    if ($session->get('is_logged_in')) {
        return $next($request, $response);
    }

    // redirect to login
    $router = $container->get('router');
    $url = $router->pathFor('get.landingpage', ['language' => $request->getAttribute('language')]);
    return $response->withRedirect($url, 302);
});

$app->add(function (Request $request, Response $response, $next) use ($container) {
    $locale = $request->getAttribute('language');
    if ($locale == 'de') {
        $locale = 'de_DE';
    }
    $translator = $container->get(Translator::class);
    $resource = __DIR__ . "/../resources/locale/" . $locale . "_messages.mo";
    $translator->setLocale($locale);
    $translator->setFallbackLocales(['en_US']);
    $translator->addResource('mo', $resource, $locale);

    return $next($request, $response);
});

$app->add(function (Request $request, Response $response, $next) use ($container) {
    $language = $request->getAttribute('language');
    if (empty($language)) {
        // Browser language
        $language = $request->getHeader('accept-language')[0];
        $language = explode(',', $language)[0];
        $language = explode('-', $language)[0];
    }
    $whitelist = [
        'de' => 'de_CH',
        'en' => 'en_US',
    ];
    if (!isset($whitelist[$language])) {
        $language = 'de';
    }
    $request = $request->withAttribute('language', $language);

    return $next($request, $response);
});

$app->add(function (Request $request, Response $response, $next) {
    $route = $request->getAttribute('route');
    if (empty($route)) {
        return $next($request, $response);
    }
    $language = $route->getArgument('language');
    $request = $request->withAttribute('language', $language);
    $response = $next($request, $response);

    return $response;
});

/**
 * Session Middleware
 *
 * @return Response
 */
$app->add(function (Request $request, Response $response, $next) {
    $session = $this->get(Session::class);
    $response = $next($request, $response);
    $session->commit();

    return $response;
});
