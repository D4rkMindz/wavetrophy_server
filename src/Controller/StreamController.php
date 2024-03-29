<?php


namespace App\Controller;


use App\Repository\StreamRepository;
use App\Service\Response\HttpMessage;
use App\Service\Response\InternalErrorCode;
use App\Service\Response\JSONResponse;
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

    /**
     * Get stream for WaveTrophy road group
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getStreamAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $wavetrophyHash = $args['wavetrophy_hash'];
        $roadGroupHash = $args['road_group_hash'];
        $locations = $this->streamRepository->getStreamForGroup($wavetrophyHash, $roadGroupHash);
        if (empty($locations)) {
            return $this->json(
                $response,
                JSONResponse::error(
                    InternalErrorCode::ELEMENT_NOT_FOUND,
                    [],
                    __('No Locations for WaveTrophy found'),
                    404,
                    HttpMessage::CODE404
                )
            );
        }
        return $this->json($response, JSONResponse::success(['locations' => $locations]));
    }
}
