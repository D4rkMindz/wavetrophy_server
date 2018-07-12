<?php

namespace App\Controller;

use Aura\Session\Segment;
use Aura\Session\Session;
use Interop\Container\Exception\ContainerException;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;

/**
 * Class AppController.
 */
class AppController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Twig
     */
    protected $twig;

    /**
     * AppController constructor.
     *
     * @param Container $container
     *
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->request = $container->get('request');
        $this->response = $container->get('response');
        $this->router = $container->get('router');
        $this->logger = $container->get(Logger::class);
        $this->twig = $container->get(Twig::class);
    }

    /**
     * Return redirect.
     *
     * @param Response $response
     * @param string $url
     * @param int $status
     *
     * @return ResponseInterface
     */
    public function redirect(Response $response, string $url, int $status = 301): ResponseInterface
    {
        return $response->withRedirect($url, $status);
    }

    /**
     * Check if Request comes from the mobile application.
     *
     * @param Request $request
     * @return bool
     */
    protected function isRequestedFromMobileApp(Request $request)
    {
        $header = $request->getHeader('X-App');
        $header = empty($header) ? 'browser' : $header[0];
        if (strtolower($header) === 'mobile') {
            return true;
        }

        return false;
    }

    // Theoretically not required
//    /**
//     * Render HTML.
//     *
//     * @param Response $response
//     * @param Request $request
//     * @param string $file
//     * @param array $viewData
//     *
//     * @return ResponseInterface
//     */
//    protected function render(
//        Response $response,
//        Request $request,
//        string $file,
//        array $viewData = []
//    ): ResponseInterface
//    {
//        $extend = [
//            'language' => $request->getAttribute('language'),
//            'page' => __('Home'),
//            'is_logged_in' => $this->session->get('is_logged_in') ?: false,
//            'active' => [
//                'home' => false
//            ]
//        ];
//        $viewData = array_replace_recursive($extend, $viewData);
//
//        return $this->twig->render($response, $file, $viewData);
//    }

    /**
     * Return JSON Response.
     *
     * @param Response $response
     * @param array $data
     * @param int $status
     *
     * @return ResponseInterface
     */
    protected function json(Response $response, $data, int $status = 200): ResponseInterface
    {
        return $response->withJson($data, $status);
    }
}
