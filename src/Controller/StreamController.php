<?php


namespace App\Controller;


use App\Repository\StreamRepository;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class StreamController extends AppController
{
    /**
     * @var StreamRepository
     */
    private $streamRepository;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->streamRepository = $container->get(StreamRepository::class);
    }

    public function getStreamAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $responseData = ['locations' => $this->streamRepository->getStreamForGroup($args['wavetrophy_hash'], $args['road_group_hash'])];
        return $this->json($response, $responseData);
    }
}
