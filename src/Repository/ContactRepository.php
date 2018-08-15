<?php


namespace App\Repository;


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
        $query->select($fields)->where(['wavetrohpy_hash' => $wavetrophyHash]);
        $contacts = $query->execute()->fetchAll('assoc');
        return $contacts ?: [];
    }
}
