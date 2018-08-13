<?php

namespace App\Controller;

use App\Service\Response\JSONResponse;
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
        return $this->json($response, JSONResponse::success(['hello' => __('Welcome to the WAVETROPHY API')]));
    }
}
