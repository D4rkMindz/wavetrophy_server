<?php
/**
 * Created by PhpStorm.
 * User: Björn Pfoster
 * Date: 08.08.2018
 * Time: 22:36
 */

namespace App\Controller;


use App\Repository\TrophyRepository;
use App\Service\Response\HttpMessage;
use App\Service\Response\InternalErrorCode;
use App\Service\Response\JSONResponse;
use Interop\Container\Exception\ContainerException;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class TrophyController
 */
class TrophyController extends AppController
{
    /**
     * @var TrophyRepository
     */
    private $trophyRepository;

    /**
     * TrophyController constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->trophyRepository = $container->get(TrophyRepository::class);
    }

    /**
     * Get all trophies action.
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function getTrophiesAction(Request $request, Response $response): ResponseInterface
    {
        $trophies = $this->trophyRepository->getAllTrophies();
        if (empty($trophies)) {
            return $this->json(
                $response,
                JSONResponse::error(
                    InternalErrorCode::ELEMENT_NOT_FOUND,
                    [],
                    __('No WaveTrophies found'),
                    404,
                    HttpMessage::CODE404
                )
            );
        }
        return $this->json($response, JSONResponse::success(['trohpies' => $trophies]));
    }

    /**
     * Get single trophy action.
     *
     * @param $request Request
     * @param $response Response
     * @param array $args
     * @return ResponseInterface
     */
    public function getTrophyAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $trophy = $this->trophyRepository->getTrohpy($args['trophy_hash']);

        if (empty($trophy)) {
            return $this->json(
                $response,
                JSONResponse::error(
                    InternalErrorCode::ELEMENT_NOT_FOUND,
                    [],
                    __('No WaveTrophy found'),
                    404,
                    HttpMessage::CODE404
                )
            );
        }
        return $this->json($response, JSONResponse::success(['trophy' => $trophy]));
    }

}
