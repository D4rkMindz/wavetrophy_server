<?php

namespace App\Repository;


use App\Service\UUID\UUID;
use App\Table\TrophyTable;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

/**
 * Class TrophyRepository
 */
class TrophyRepository
{
    /**
     * @var TrophyTable
     */
    private $trophyTable;

    /**
     * TrophyRepository constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->trophyTable = $container->get(TrophyTable::class);
    }

    /**
     * Get all trophies.
     *
     * @return array
     */
    public function getAllTrophies(): array
    {
        return $this->trophyTable->getAll();
    }

    /**
     * Get single trophy by trophy hash.
     *
     * @param string $trophyHash
     * @return array
     */
    public function getTrohpy(string $trophyHash): array
    {
        return $this->trophyTable->getByHash($trophyHash);
    }

    /**
     * Create trophy.
     *
     * @param string $name
     * @param string $country
     * @param string $userHash
     * @return string|null
     */
    public function createTrohpy(string $name, string $country, string $userHash): ?string
    {
        $row = [
            'hash' => UUID::generate(),
            'name' => $name,
            'country' => $country,
            'created_by' => $userHash,
        ];
        $inserted = $this->trophyTable->insert($row);

        if ($inserted) {
            return $row['hash'];
        }
        return null;
    }

    /**
     * Modify trophy.
     *
     * @param string $hash
     * @param string $name
     * @param string $country
     * @param string $userHash
     * @return bool
     */
    public function modifyTrohpy(string $hash, string $name, string $country, string $userHash): bool
    {
        $row = [];
        if (!empty($name)) {
            $row['name'] = $name;
        }
        if (!empty($country)) {
            $row['country'] = $country;
        }
        if (empty($row)) {
            return false;
        }
        $row['modified_at'] = date('Y-m-d H:i:s');
        $row['modified_by'] = $userHash;
        return (bool)$this->trophyTable->modify($row, ['hash' => $hash]);
    }

    /**
     * Archive trophy.
     *
     * @param string $hash
     * @param string $userHash
     * @return bool
     */
    public function archive(string $hash, string $userHash): bool
    {
        return $this->archive($hash, $userHash);
    }
}
