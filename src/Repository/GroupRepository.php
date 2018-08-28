<?php


namespace App\Repository;


use App\Service\UUID\UUID;
use App\Table\GroupTable;
use App\Table\TrophyTable;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

class GroupRepository extends AppRepository
{
    /**
     * @var GroupTable
     */
    private $groupTable;

    /**
     * @var TrophyTable
     */
    private $wavetrophyTable;

    /**
     * GroupRepository constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->groupTable = $container->get(GroupTable::class);
        $this->wavetrophyTable = $container->get(TrophyTable::class);
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
        $group = $this->groupTable->getTablename();
        $wavetrophy = $this->wavetrophyTable->getTablename();
        $fields = [
            'hash' => $group . '.hash',
            'name' => $group . '.name',
            'created_at' => $group . '.created_at',
            'created_by' => $group . '.created_by',
            'modified_at' => $group . '.modified_at',
            'modified_by' => $group . '.modified_by',
            'archived_at' => $group . '.archived_at',
            'archived_by' => $group . '.archived_by',
            'wavetrophy_hash' => $wavetrophy . '.hash',
            'wavetrophy_name' => $wavetrophy . '.name'
        ];
        $query = $this->groupTable->newSelect();
        $query->select($fields)
            ->join([
                [
                    'table' => 'wavetrophy',
                    'type' => 'LEFT',
                    'conditions' => $group . '.wavetrophy_hash = ' . $wavetrophy . '.hash',
                ],
            ])
            ->where([$group.'.wavetrophy_hash' => $trophyHash])
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
        $group = $this->groupTable->getTablename();
        $wavetrophy = $this->wavetrophyTable->getTablename();
        $fields = [
            'hash' => $group . '.hash',
            'name' => $group . '.name',
            'created_at' => $group . '.created_at',
            'created_by' => $group . '.created_by',
            'modified_at' => $group . '.modified_at',
            'modified_by' => $group . '.modified_by',
            'archived_at' => $group . '.archived_at',
            'archived_by' => $group . '.archived_by',
            'wavetrophy_hash' => $wavetrophy . '.hash',
            'wavetrophy_name' => $wavetrophy . '.name'
        ];
        $query = $this->groupTable->newSelect();
        $query->select($fields)
            ->join([
                [
                    'table' => 'wavetrophy',
                    'type' => 'LEFT',
                    'conditions' => $group . '.wavetrophy_hash = ' . $wavetrophy . '.hash',
                ],
            ])
            ->where([$group . '.wavetrophy_hash' => $trophyHash, $group .'.hash' => $groupHash]);
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

    /**
     * Create group.
     *
     * @param string $userHash
     * @param string $wavetrophyHash
     * @param string $name
     * @return string
     */
    public function createGroup(string $userHash, string $wavetrophyHash, string $name)
    {
        $row = [
            'hash' => UUID::generate(),
            'wavetrophy_hash' => $wavetrophyHash,
            'name' => $name,
        ];
        return $this->groupTable->insert($row, $userHash);
    }

    /**
     * Modify group
     *
     * @param string $userHash
     * @param string $groupHash
     * @param string $name
     * @return \Cake\Database\StatementInterface
     */
    public function updateGroup(string $userHash, string $groupHash, string $name)
    {
        return $this->groupTable->modify(['name' => $name], ['hash' => $groupHash], $userHash);
    }

    /**
     * Archive group
     *
     * @param string $userHash
     * @param string $groupHash
     * @return bool
     */
    public function archiveGroup(string $userHash, string $groupHash)
    {
        return $this->groupTable->archive($groupHash, $userHash);
    }
}
