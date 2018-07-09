<?php


namespace App\Service\Authentication;


use App\Repository\Exception\EmptySetException;
use App\Repository\UserRepository;
use App\Util\ValidationContext;
use Slim\Container;

class AuthenticationValidation
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(Container $container)
    {
        $this->userRepository = $container->get(UserRepository::class);
    }

    public function validateAuthentication(string $username, string $password)
    {
        $validationContext = new ValidationContext(__('Login failed'));
        try {
            if (is_email($username)) {
                $hash = $this->userRepository->getPaswordByEmail($username);
            } else {
                $hash = $this->userRepository->getPasswordByUsername($username);
            }
            if (!password_verify($password, $hash)) {
                 $validationContext->setError('main', __('Password or username invalid'));
            }
        } catch (EmptySetException $e) {
            $validationContext->setError('main', __('Password or username invalid'));
        }
        return $validationContext;
    }
}
