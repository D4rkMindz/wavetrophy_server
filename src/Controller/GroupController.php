<?php


namespace App\Controller;


use App\Repository\GroupRepository;
use App\Service\Response\HttpMessage;
use App\Service\Response\InternalErrorCode;
use App\Service\Response\JSONResponse;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Http\Message\ResponseInterface;

class GroupController extends AppController
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->groupRepository = $container->get(GroupRepository::class);
    }

    /**
     * Get all wavetrophy groups.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getGroupsAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $groups = $this->groupRepository->getAllGroups($args['wavetrophy_hash']);
        if (empty($groups)) {
            return $this->json(
                $response,
                JSONResponse::error(
                    InternalErrorCode::ELEMENT_NOT_FOUND,
                    [],
                    __('No WaveTrophy Groups found'),
                    404,
                    HttpMessage::CODE404
                )
            );
        }
        return $this->json($response, JSONResponse::success(['groups' => $groups]));
    }

    /**
     * Get single wavetrophy group.
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function getGroupAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $group = $this->groupRepository->getGroup($args['wavetrophy_hash'], $args['road_group_hash']);

        if (empty($group)) {
            return $this->json(
                $response,
                JSONResponse::error(
                    InternalErrorCode::ELEMENT_NOT_FOUND,
                    [],
                    __('No WaveTrophy Group found'),
                    404,
                    HttpMessage::CODE404
                )
            );
        }
        return $this->json($response, JSONResponse::success(['group' => $group]));
    }
}
