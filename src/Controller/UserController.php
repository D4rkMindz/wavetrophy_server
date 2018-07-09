<?php


namespace App\Controller;


use Interop\Container\Exception\ContainerException;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends AppController
{
    /**
     * UserController constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * Login action
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function loginAction(Request $request, Response $response): ResponseInterface
    {
        return $this->render($response, $request, 'User/login.twig', ['page'=>__('Login'), 'active'=> 'login']);
    }

    /**
     * Register Action
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function registerAction(Request $request, Response $response): ResponseInterface
    {
        return $this->render($response, $request, 'User/register.twig', ['page' => __('Register'), 'active' => 'register']);
    }
}
