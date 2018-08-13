<?php


namespace App\Controller;


use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class StreamController extends AppController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function indexAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $waveHash = $args['wave_hash'];
        $groupHash = $args['group_hash'];



        $responseData = [];
        return $this->json($response, $responseData);
    }
}
