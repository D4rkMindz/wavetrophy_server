<?php


namespace App\Repository;


use App\Service\UUID\UUID;
use App\Table\ContactTable;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

class ContactRepository extends AppRepository
{
    /**
     * @var ContactTable
     */
    private $contactTable;

    /**
     * ContactRepository constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->contactTable = $container->get(ContactTable::class);
    }

    /**
     * @param string $wavetrophyHash
     * @return array
     */
    public function getContactsForWavetrophy(string $wavetrophyHash)
    {
        $fields = [
            'position',
            'phonenumber',
            'first_name',
            'last_name',
            'email',
        ];
        $query = $this->contactTable->newSelect();
        $query->select($fields)->where(['wavetrophy_hash' => $wavetrophyHash]);
        $contacts = $query->execute()->fetchAll('assoc');
        return $contacts ?: [];
    }

    /**
     * Create contact for wavetrophy
     *
     * @param string $wavetrophyHash The hash of the wave where the contact should be visible
     * @param string $creatorHash The hash of the contact creator (the signed in user)
     * @param string $position
     * @param string $phonenumber
     * @param string $firstname
     * @param string $lastname
     * @param null|string $email
     * @return null|string The hash of the created contact
     */
    public function createContact(string $wavetrophyHash, string $creatorHash, string $position, string $phonenumber, string $firstname, string $lastname, ?string $email): ?string
    {
        $row = [
            'hash' => UUID::generate(),
            'position' => $position,
            'phonenumber' => $phonenumber,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'email' => $email ?: null,
            'wavetrophy_hash' => $wavetrophyHash,
        ];
        return $this->contactTable->insert($row, $creatorHash);
    }
}
