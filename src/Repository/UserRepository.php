<?php

namespace App\Repository;

use App\Service\Mail\MailToken;
use App\Table\CityTable;
use App\Table\EmailTokenTable;
use App\Table\LanguageTable;
use App\Table\PermissionTable;
use App\Table\UserTable;
use App\Util\Formatter;
use App\Util\Role;
use Cake\Database\Query;
use Exception;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Slim\Container;

/**
 * Class UserRepository
 */
class UserRepository extends AppRepository
{
    /**
     * @var UserTable
     */
    private $userTable;

    /**
     * @var LanguageTable
     */
    private $languageTable;

    /**
     * @var PermissionTable
     */
    private $permissionTable;

    /**
     * @var Formatter
     */
    private $formatter;

    /**
     * @var EmailTokenTable
     */
    private $emailTokenTable;

    /**
     * UserRepository constructor.
     *
     * @param Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        $this->userTable = $container->get(UserTable::class);
        $this->languageTable = $container->get(LanguageTable::class);
        $this->permissionTable = $container->get(PermissionTable::class);
        $this->emailTokenTable = $container->get(EmailTokenTable::class);

        $this->formatter = new Formatter();
    }

    /**
     * Get ID by username
     *
     * @param string $username
     * @return string
     */
    public function getHashByUsername(string $username): string
    {
        $where = ['username' => $username];
        if (is_email($username)) {
            $where = ['email' => $username];
        }
        $query = $this->userTable->newSelect();
        $query->select('hash')->where($where);
        $row = $query->execute()->fetch('assoc');

        return !empty($row) ? $row['hash'] : '';
    }

    /**
     * Check if user can login by username.
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function checkLoginByUsername(string $username, string $password): bool
    {
        $query = $this->userTable->newSelect();
        $query->select(['password'])->where(['username' => $username]);
        $row = $query->execute()->fetch('assoc');
        if (empty($row)) {
            return false;
        }

        return password_verify($password, $row['password']);
    }

    /**
     * Check if user can login by email.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function checkLoginByEmail(string $email, string $password): bool
    {
        $query = $this->userTable->newSelect();
        $query->select(['password'])->where(['email' => $email]);
        $row = $query->execute()->fetch('assoc');
        if (empty($row)) {
            return false;
        }

        return password_verify($password, $row['password']);
    }

    /**
     * Get all users.
     *
     * @param int $limit
     * @param int $page
     * @return array with userData
     */
    public function getUsers(int $limit, int $page): array
    {
        $query = $this->getUserQuery()->limit($limit)->page($page);
        $users = $query->execute()->fetchAll('assoc');

        if (empty($users)) {
            return [];
        }

        foreach ($users as $key => $user) {
            $users[$key] = $this->formatter->formatUser($user);
        }

        return $users;
    }

    /**
     * Get single user.
     *
     * @param string $hash
     * @return array with single user
     */
    public function getUser(string $hash): array
    {
        $userTableName = $this->userTable->getTablename();
        $query = $this->getUserQuery();
        $query->where([$userTableName . '.hash' => $hash]);
        $user = $query->execute()->fetch('assoc');
        if (empty($user)) {
            return [];
        }

        return $this->formatter->formatUser($user);
    }

    /**
     * Get permission.
     *
     * @param string $userHash
     * @return array
     */
    public function getPermission(string $userHash): array
    {
        $permissionTablename = $this->permissionTable->getTablename();
        $userTableName = $this->userTable->getTablename();

        $fields = [
            'hash' => $permissionTablename . '.hash',
            'level' => $permissionTablename . '.level',
        ];

        $query = $this->userTable->newSelect();
        $query->select($fields)->where([$userTableName . '.hash' => $userHash])->join([
            [
                'table' => $permissionTablename,
                'type' => 'INNER',
                'conditions' => $userTableName . '.permission_hash = ' . $permissionTablename . '.hash',
            ],
        ]);
        $row = $query->execute()->fetch('assoc');

        return !empty($row) ? $row : [];
    }

    /**
     * Insert user.
     *
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $postcode
     * @param string $username
     * @param string $password
     * @param string $ceviName
     * @param string $languageHash
     * @param string $departmentHash
     * @return array last inserted user id
     */
    public function signupUser(
        string $email,
        string $firstName,
        string $lastName,
        string $postcode,
        string $username,
        string $password,
        string $ceviName,
        string $languageHash,
        string $departmentHash
    ): array
    {

    }

    /**
     * Get email token by id
     *
     * @param string $emailToken
     * @return string
     */
    public function getUserIdByEmailToken(string $emailToken): string
    {
        $query = $this->emailTokenTable->newSelect();
        $query->select(['user_hash'])
            ->where(['token' => $emailToken, 'issued_at <= ' => date('Y-m-d H:i:s')]);
        $row = $query->execute()->fetch('assoc');
        return !empty($row) ? $row['user_hash'] : '';
    }

    /**
     * Confirm email as verified
     *
     * @param string $userHash
     * @return bool
     */
    public function confirmEmail(string $userHash): bool
    {
        return $this->userTable->modify(['email_verified' => true], ['hash' => $userHash], 0);
    }

    /**
     * Check if username already exists.
     *
     * @param string $username
     * @return bool
     */
    public function existsUsername(string $username): bool
    {
        $query = $this->userTable->newSelect();
        $query->select('username')->where(['username' => $username]);
        $row = $query->execute()->fetch();

        return empty($row);
    }

    /**
     * Check if user exists.
     *
     * @param string $userHash
     * @return bool
     */
    public function existsUser(string $userHash): bool
    {
        return $this->exists($this->userTable, ['hash' => $userHash]);
    }

    /**
     * Check if user exists by user ID.
     *
     * @param string $userId
     * @return bool
     */
    public function existsUserById(string $userId)
    {
        return $this->exists($this->userTable, ['id' => $userId]);
    }

    /**
     * Update user.
     *
     * @param array $data
     * @param string $whereHash
     * @param string $userId
     * @return bool true if users signup is completed
     */
    public function updateUser(array $data, string $whereHash, string $userId): bool
    {
        $update = [];

        if (array_key_exists('position_hash', $data)) {
            $update['position_hash'] = $data['position_hash'];
        }

        if (array_key_exists('username', $data)) {
            $update['username'] = $data['username'];
        }

        if (array_key_exists('password', $data)) {
            $update['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        if (array_key_exists('language', $data)) {
            $update['language'] = $data['language'];
        }

        if (array_key_exists('first_name', $data)) {
            $update['first_name'] = $data['first_name'];
        }

        if (array_key_exists('email', $data)) {
            $update['email'] = $data['email'];
        }

        if (array_key_exists('last_name', $data)) {
            $update['last_name'] = $data['last_name'];
        }

        if (array_key_exists('is_public', $data)) {
            $update['is_public'] = (bool)$data['is_public'];
        }

        if (array_key_exists('mobile_number', $data)) {
            try {
                $update['mobile_number'] = PhoneNumberUtil::getInstance()->parse($data['mobile_number']);
            } catch (NumberParseException $e) {
                $data['mobile_number'] = null;
                // TODO maybe fail with false?
            }
        }

        $update['modified_at'] = date('Y-m-d H:i:s');
        $update['modified_by'] = $userId;

        try {
            $this->userTable->modify($update, ['hash' => $whereHash], $userId);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Delete user.
     *
     * @param string $userHash
     * @param string $executorId
     * @return bool
     */
    public function deleteUser(string $userHash, string $executorId): bool
    {
        try {
//            $this->userTable->archive($executorId, ['hash' => $userHash]);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * Get user query.
     *
     * @return Query
     */
    private function getUserQuery(): Query
    {
        $query = $this->userTable->newSelect();

        $userTableName = $this->userTable->getTablename();
        $permissionTablename = $this->permissionTable->getTablename();

        $fields = [
            'hash' => $userTableName . '.hash',
            'permission_hash' => $userTableName . '.permission_hash',
            'permission_name' => $permissionTablename . '.name',
            'username' => $userTableName . '.username',
            'language' => $userTableName . '.language',
            'first_name' => $userTableName . '.first_name',
            'last_name' => $userTableName . '.last_name',
            'email' => $userTableName . '.email',
            'is_public' => $userTableName . '.is_public',
            'mobile_number' => $userTableName . '.mobile_number',
            'created_at' => $userTableName . '.created_at',
            'created_by' => $userTableName . '.created_by',
            'modified_at' => $userTableName . '.modified_at',
            'modified_by' => $userTableName . '.modified_by',
            'archived_by' => $userTableName . '.archived_by',
            'archived_at' => $userTableName . '.archived_at',
        ];

        $query->select($fields)
            ->join([
                [
                    'table' => $permissionTablename,
                    'type' => 'LEFT',
                    'conditions' => $userTableName . '.permission_hash=' . $permissionTablename . '.hash',
                ],
            ]);

        return $query;
    }
}
