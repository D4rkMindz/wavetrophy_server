<?php


namespace App\Controller;


use App\Repository\GroupRepository;
use App\Service\Response\HttpMessage;
use App\Service\Response\InternalErrorCode;
use App\Service\Response\JSONResponse;
use App\Service\Validation\GroupValidation;
use Interop\Container\Exception\ContainerException;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class GroupController extends AppController
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var GroupValidation
     */
    private $groupValidation;

    /**
     * GroupController constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->groupRepository = $container->get(GroupRepository::class);
        $this->groupValidation = $container->get(GroupValidation::class);
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

    /**
     * @param $request Request
     * @param $response Response
     * @param array $args
     * @return ResponseInterface
     */
    public function createGroupAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $wavetrophyHash = $args['wavetrophy_hash'];
        $json = $request->getBody()->__toString();
        $data = json_decode($json, true);
        $name = array_value('name', $data);

        $validationContext = $this->groupValidation->validateCreation($wavetrophyHash, $name);
        if ($validationContext->fails()) {
            return $this->errorFromValidationContext($response, $validationContext);
        }

        $groupHash = $this->groupRepository->createGroup($this->jwt['user_hash'], $wavetrophyHash, $name);
        $responseData = JSONResponse::success(['group_hash' => $groupHash]);

        return $this->json($response, $responseData);
    }

    /**
     * Controller Action.
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function updateGroupAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $name = json_decode($request->getBody()->__toString(), true)['name'];
        $validationContext = $this->groupValidation->validateUpdate($name);
        if ($validationContext->fails()) {
            return $this->errorFromValidationContext($response, $validationContext);
        }

        $this->groupRepository->updateGroup($this->jwt['user_hash'], $args['road_group_hash'], $name);

        return $this->json($response, ['message' => __('Updated group successfully')]);
    }

    /**
     * @param $request Request
     * @param $response Response
     * @param array $args
     * @return ResponseInterface
     */
    public function deleteGroupAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $wavetrophyHash = $args['wavetrophy_hash'];
        $roadGroupHash = $args['road_group_hash'];

        $validationContext = $this->groupValidation->validateDeletion($wavetrophyHash, $roadGroupHash);
        if ($validationContext->fails()) {
            return $this->errorFromValidationContext($response, $validationContext);
        }

        $eventArchived = $this->groupRepository->archiveGroup($this->jwt['user_hash'], $roadGroupHash);
        if (!$eventArchived) {
            $responseData = JSONResponse::error(InternalErrorCode::ACTION_FAILED, ['error' => __('Group not deleted')], __('Event not deleted'));
            return $this->error($response, __('Group not deleted'), 422, $responseData);
        }

        $responseData = JSONResponse::success(['info' => __('Group deleted')]);

        return $this->json($response, $responseData);
    }
}
