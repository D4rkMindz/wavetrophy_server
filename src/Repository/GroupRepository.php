<?php


namespace App\Repository;


use App\Table\GroupTable;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

class GroupRepository extends AppRepository
{
    /**
     * @var GroupTable
     */
    private $groupTable;

    /**
     * GroupRepository constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->groupTable = $container->get(GroupTable::class);
    }

    /**
     * Get all groups
     * 
     * @param string $trophyHash
     * @param int $limit
     * @param int $page
     * @return array
     */
    public function getAllGroups(string $trophyHash, int $limit = 1000, int $page = 1): array
    {
        $fields = [
            'hash',
            'name',
            'created_at',
            'created_by',
            'modified_at',
            'modified_by',
            'archived_at',
            'archived_by',
        ];
        $query = $this->groupTable->newSelect();
        $query->select($fields)
            ->where(['wavetrophy_hash' => $trophyHash])
            ->limit($limit)
            ->page($page);
        $rows = $query->execute()->fetchAll('assoc');
        return $rows ?: [];
    }

    /**
     * Get single group
     *
     * @param string $trophyHash
     * @param string $groupHash
     * @return array
     */
    public function getGroup(string $trophyHash, string $groupHash)
    {
        $fields = [
            'hash',
            'name',
            'created_at',
            'created_by',
            'modified_at',
            'modified_by',
            'archived_at',
            'archived_by',
        ];
        $query = $this->groupTable->newSelect();
        $query->select($fields)
            ->where(['wavetrophy_hash' => $trophyHash, 'hash' => $groupHash]);
        $row = $query->execute()->fetchAll('assoc');
        return $row ?: [];
    }

    /**
     * Check if group exists
     *
     * @param string $roadGroupHash
     * @return bool
     */
    public function existsGroup(string $roadGroupHash)
    {
        return $this->exists($this->groupTable, ['hash' => $roadGroupHash]);
    }
}
