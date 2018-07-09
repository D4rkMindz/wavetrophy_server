<?php


namespace App\Repository;


use App\Repository\Exception\EmptySetException;
use App\Table\UserTable;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

class UserRepository
{
    /**
     * @var UserTable
     */
    private $userTable;

    /**
     * UserRepository constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->userTable = $container->get(UserTable::class);
    }

    /**
     * Get password by username
     *
     * @param string $username
     * @return string
     * @throws EmptySetException
     */
    public function getPasswordByUsername(string $username)
    {
        $query = $this->userTable->newSelect();
        $query->select(['password'])->where(['username' => $username]);
        $row = $query->execute()->fetch('assoc');
        if (empty($row)) {
            throw new EmptySetException(__('Username not found'));
        }

        return $row['password'];
    }

    /**
     * Get password by EMail
     *
     * @param string $email
     * @return string
     * @throws EmptySetException
     */
    public function getPaswordByEmail(string $email)
    {
        $query = $this->userTable->newSelect();
        $query->select(['password'])->where(['email' => $email]);
        $row = $query->execute()->fetch('assoc');

        if (empty($row)) {
            throw new EmptySetException(__('Email not found'));
        }

        return $row['password'];
    }
}
