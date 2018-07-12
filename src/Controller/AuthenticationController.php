<?php


namespace App\Controller\API;

use App\Controller\AppController;
use App\Service\Authentication\AuthenticationValidation;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthenticationController extends AppController
{
    /**
     * @var AuthenticationValidation
     */
    private $authenticationValidation;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->authenticationValidation = $container->get(AuthenticationValidation::class);
        $this->router= $container->get('router');
    }

    /**
     * Controller Action.
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function authenticateAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $body = $request->getBody()->__toString();
        $data = json_decode($body, true);
        $validationContext = $this->authenticationValidation->validateAuthentication($data['username'], $data['password']);
        if ($validationContext->fails()) {
            return $this->json($response, $validationContext->toArray(), 422);
        }
        if (!isRequestedFromMobileApp($request)) {
            $this->session->set('is_logged_in', true);
        }

        $responseData = [
            'message' => __('Successfully authenticated'),
            'language' => $request->getAttribute('language'),
        ];

        return $this->json($response, $responseData);
    }

    /**
     * Controller Action.
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function logoutAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $this->session->set('is_logged_in', false);

        return $this->redirect($response, $this->router->pathFor('get.landingpage'));
    }
}
