<?php

namespace App\Controller;

use App\Repository\LanguageRepository;
use App\Repository\UserRepository;
use App\Service\Mail\MailerInterface;
use App\Service\User\UserValidation;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Twig_Environment;

/**
 * UserController
 */
class UserController extends AppController
{
    /**
     * @var UserRepository;
     */
    private $userRepository;

    /**
     * @var UserValidation
     */
    private $userValidation;

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @var boolean
     */
    private $isProduction;

    /**
     * UserController constructor.
     *
     * @param Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->userRepository = $container->get(UserRepository::class);
        $this->userValidation = $container->get(UserValidation::class);
        $this->twig = $container->get(Twig_Environment::class);
        $this->isProduction = $container->get('settings')->get('isProduction');
    }

    /**
     * Get all users.
     *
     * @auth JWT
     * @get int|string limit
     * @get int|string page
     * @get int|string offset
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getAllUsersAction(Request $request, Response $response): Response
    {
        $data = $this->getLimitationParams($request);
        $users = $this->userRepository->getUsers($data['limit'], $data['page']);

        if (empty($users)) {
            return $this->error($response, __('No users found'), 404);
        }

        return $this->json($response, ['users' => $users]);
    }

    /**
     * Get single user.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getUserAction(Request $request, Response $response): Response
    {
        $userHash = (string)$request->getAttribute('route')->getArgument('user_hash');
        $user = $this->userRepository->getUser($userHash);
        if (empty($user)) {
            return $this->error($response, __('No user found'), 404);
        }

        return $this->json($response, ['user' => $user]);
    }

    /**
     * Update user action.
     *
     * @put null|string|int postcode
     * @put null|string language Abbreviation like de en fr it
     * @put null|string department_hash
     * @put null|string position_hash
     * @put null|string gender_hash
     * @put null|string first_name
     * @put null|string email
     * @put null|string username
     * @put null|string password
     * @put null|bool js_certificate
     * @put null|bool js_certificate_until Required if js_certificate is true. As Time
     * @put null|string last_name
     * @put null|string address
     * @put null|string cevi_name
     * @put null|string|int birthdate As Time
     * @put null|string phone
     * @put null|string mobile
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function updateUserAction(Request $request, Response $response, array $args): Response
    {
//        $json = (string)$request->getBody();
//        $data = json_decode($json, true);
//
//        return $this->error($response, $validationContext->getMessage(), 422, $validationContext->toArray());
//
//        $singupCompleted = $this->userRepository->updateUser($data, $args['user_hash'], $this->jwt['user_id']);
//
//        $responseData = [
//            'info' => [
//                'message' => __('Updated user successfully'),
//                'signup_completed' => (bool)$singupCompleted,
//            ],
//        ];
//
//        return $this->json($response, $responseData);
    }

    /**
     * Delete user action.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function deleteUserAction(Request $request, Response $response, array $args): Response
    {
        if (!$this->userRepository->deleteUser($args['user_hash'], $this->jwt['user_id'])) {
            $this->error($response, 'Forbidden', 403, ['message' => __('Deleting user failed')]);
        }

        return $this->json($response, ['message' => __('Deleted user successfully')]);
    }
}
