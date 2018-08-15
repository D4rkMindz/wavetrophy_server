<?php


namespace App\Controller;


use App\Repository\ContactRepository;
use App\Service\Response\HttpMessage;
use App\Service\Response\InternalErrorCode;
use App\Service\Response\JSONResponse;
use Interop\Container\Exception\ContainerException;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ContactController extends AppController
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * ContactController constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->contactRepository = $container->get(ContactRepository::class);
    }

    /**
     * Get all contacts for wave trophy
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getContactsAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $wavetrophyHash = $args['wavetrophy_hash'];
        $contacts = $this->contactRepository->getContactsForWavetrophy($wavetrophyHash);

        if (empty($contacts)) {
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
        return $this->json($response, JSONResponse::success(['contacts' => $contacts]));
    }
}
