<?php


namespace App\Controller;


use App\Repository\ContactRepository;
use App\Service\Response\JSONResponse;
use App\Service\Validation\ContactValidation;
use App\Util\ValidationContext;
use Interop\Container\Exception\ContainerException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
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
     * @var ContactValidation
     */
    private $contactValidation;

    /**
     * ContactController constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->contactRepository = $container->get(ContactRepository::class);
        $this->contactValidation = $container->get(ContactValidation::class);
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
            return $this->error($response, __('No WaveTrophies found'));
        }
        return $this->json($response, JSONResponse::success(['contacts' => $contacts]));
    }

    /**
     * Controller Action.
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function createContactAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $json = $request->getBody()->__toString();
        $data = json_decode($json, true);

        $wavetrophyHash = $args['wavetrophy_hash'];
        $position = (string)array_value('position', $data);
        $phonenumber = (string)array_value('phonenumber', $data);
        $firstname = (string)array_value('firstname', $data);
        $lastname = (string)array_value('lastname', $data);
        $email = (string)array_value('email', $data);

        $validationContext = $this->contactValidation->validateCreation($wavetrophyHash, $position, $phonenumber, $firstname, $lastname, $email);
        if ($validationContext->fails()) {
            return $this->errorFromValidationContext($response, $validationContext);
        }

        try {
            $phonenumber = PhoneNumberUtil::getInstance()->parse($phonenumber);
        } catch (NumberParseException $e) {
            // This code should NEVER BE EXECUTED (is prevented in ContactValidation::validateCreation()
            $validationContext = new ValidationContext(__('Contact information invalid'));
            $validationContext->setError(ContactValidation::FIELD_NAME_PHONENUMBER, __('Phonenumber is not valid'));
            return $this->errorFromValidationContext($response, $validationContext);
        }

        $contactHash = $this->contactRepository->createContact($wavetrophyHash, $this->jwt['user_hash'], $position, $phonenumber, $firstname, $lastname, $email);

        $data = ['contact' => $contactHash];
        $responseData = JSONResponse::success($data);
        return $this->json($response, $responseData);
    }
}
