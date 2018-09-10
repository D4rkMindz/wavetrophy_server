<?php

namespace App\Controller;


use App\Repository\EventRepository;
use App\Service\Response\HttpMessage;
use App\Service\Response\InternalErrorCode;
use App\Service\Response\JSONResponse;
use App\Service\Validation\EventValidation;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class EventController extends AppController
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var EventValidation
     */
    private $eventValidation;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->eventRepository = $container->get(EventRepository::class);
        $this->eventValidation = $container->get(EventValidation::class);
    }

    /**
     * Get events.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getEventsAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $roadGroupHash = $args['road_group_hash'];
        $locationHash = $args['location_hash'];
        $events = $this->eventRepository->getAllEvents($roadGroupHash, $locationHash);

        if (empty($events)) {
            return $this->json(
                $response,
                JSONResponse::error(
                    InternalErrorCode::ELEMENT_NOT_FOUND,
                    [],
                    __('No WaveTrophy Events for location found'),
                    404,
                    HttpMessage::CODE404
                )
            );
        }
        return $this->json($response, JSONResponse::success(['events' => $events]));
    }

    /**
     * @param $request Request
     * @param $response Response
     * @param array $args
     * @return ResponseInterface
     */
    public function createEventAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $wavetrophyHash = $args['wavetrophy_hash'];
        $roadGroupHash = $args['road_group_hash'];
        $locationHash = $args['location_hash'];
        $json = $request->getBody()->__toString();
        $data = json_decode($json, true);
        $title = array_value('title', $data);
        $description = array_value('description', $data);
        $start = date('Y-m-d H:i:s', array_value('start', $data));
        $end = date('Y-m-d H:i:s', array_value('end', $data));
        $day = array_value('day', $data);
        $images = array_value('images', $data);

        $validationContext = $this->eventValidation->validateCreation(
            $wavetrophyHash,
            $roadGroupHash,
            $locationHash,
            $title,
            $description,
            $start,
            $end,
            $day
        );

        if ($validationContext->fails()) {
            return $this->errorFromValidationContext($response, $validationContext);
        }

        $eventHash = $this->eventRepository->createEvent(
            $this->jwt['user_hash'],
            $roadGroupHash,
            $locationHash,
            $title,
            $description,
            $start,
            $end,
            $day,
            $images
        );

        $responseData = JSONResponse::success(['event_hash' => $eventHash]);
        return $this->json($response, $responseData);
    }

    /**
     * @param $request Request
     * @param $response Response
     * @param array $args
     * @return ResponseInterface
     */
    public function deleteEventAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $wavetrophyHash = $args['wavetrophy_hash'];
        $roadGroupHash = $args['road_group_hash'];
        $locationHash = $args['location_hash'];
        $eventHash = $args['event_hash'];

        $validationContext = $this->eventValidation->validateDeletion($wavetrophyHash, $roadGroupHash, $locationHash, $eventHash);
        if ($validationContext->fails()) {
            return $this->errorFromValidationContext($response, $validationContext);
        }

        $eventArchived = $this->eventRepository->archiveEvent($this->jwt['user_hash'], $eventHash);
        if (!$eventArchived) {
            $responseData = JSONResponse::error(InternalErrorCode::ACTION_FAILED, ['error' => __('Event not deleted')], __('Event not deleted'));
            return $this->error($response, __('Event not deleted'), 422, $responseData);
        }

        $responseData = JSONResponse::success(['info' => __('Event deleted')]);

        return $this->json($response, $responseData);
    }
}
