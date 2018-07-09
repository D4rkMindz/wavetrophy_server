<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class IndexController.
 */
class IndexController extends AppController
{
    /**
     * IndexController constructor.
     *
     * @param Container $container
     *
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * Index method.
     *
     * @param Request $request
     * @param Response $response
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return ResponseInterface
     */
    public function indexAction(Request $request, Response $response): ResponseInterface
    {
        return $this->render($response, $request, 'Home/home.index.twig', ['page' => __('Hello'), 'active' => 'info']);
    }

    /**
     * Control Panel action.
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function homeAction(Request $request, Response $response): ResponseInterface
    {
        $trophies = [
            ['url' => baseurl('/trophies/wave2018'), 'name' => 'WAVE 2018', 'country' => 'Schweiz'],
            ['url' => baseurl('/trophies/wave2018'), 'name' => 'WAVE 2018', 'country' => 'Schweiz'],
            ['url' => baseurl('/trophies/wave2018'), 'name' => 'WAVE 2018', 'country' => 'Schweiz'],
            ['url' => baseurl('/trophies/wave2018'), 'name' => 'WAVE 2018', 'country' => 'Schweiz'],
        ]; // TODO
        $responseData = [
            'trophies' => $trophies,
            'page' => __('Control Panel'),
            'active' => 'panel'
        ];
        return $this->render($response, $request, 'Panel/panel.twig', $responseData);
    }

    /**
     * Controller Action.
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function landingpageAction(Request $request, Response $response, array $args): ResponseInterface
    {
        return $this->render($response, $request, 'Home/landingpage.twig', ['page' => __('Hello')]);
    }
}
