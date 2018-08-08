<?php

namespace App\Table;

use Cake\Database\Connection;
use Cake\Database\Query;
use Cake\Database\StatementInterface;

/**
 * Class AppTable.
 */
abstract class AppTable implements TableInterface
{
    protected $table = null;

    protected $connection = null;

    /**
     * AppTable constructor.
     *
     * @todo rename model to table
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection = null)
    {
        $this->connection = $connection;
    }

    /**
     * Get Query.
     *
     * @return Query
     */
    public function newSelect(): Query
    {
        return $this->connection->newQuery()->from($this->table);
    }

    /**
     * Get all entries from database.
     *
     * @param int $limit
     * @param int $page
     * @return array $rows
     */
    public function getAll(int $limit = 1000, $page = 1): array
    {
        $query = $this->newSelect();
        $query->select('*')->limit($limit)->page($page);
        $rows = $query->execute()->fetchAll('assoc');

        if (empty($rows)) {
            return [];
        }

        foreach ($rows as $key => $row) {
            $rows[$key] = $this->unsetRowID($row);
        }

        return $rows;
    }

    /**
     * Get entry by hash.
     *
     * @param string $hash
     * @return array
     */
    public function getByHash(string $hash): array
    {
        $query = $this->newSelect();
        $query->select('*')->where(['hash' => $hash]);
        $row = $query->execute()->fetchAll('assoc');

        if (empty($row)) {
            return [];
        }

        return $this->unsetRowID($row);
    }

    private function unsetRowID(array $singleRow)
    {
        if (array_key_exists('id', $singleRow)) {
            unset($singleRow['id']);
        }
        return $singleRow;
    }

    /**
     * Insert into database.
     *
     * @param array $row with data to insertUser into database
     *
     * @return StatementInterface
     */
    public function insert(array $row): StatementInterface
    {
        return $this->connection->insert($this->table, $row);
    }

    /**
     * Update database.
     *
     * @param array $row
     * @param array $where The where condition
     * @return StatementInterface
     */
    public function modify(array $row, array $where): StatementInterface
    {
        $query = $this->connection->newQuery();
        $query->update($this->table)
            ->set($row)
            ->where($where);

        return $query->execute();
    }

    /**
     * Delete from database.
     *
     * @param string $id
     *
     * @return StatementInterface
     */
    public function delete(string $id): StatementInterface
    {
        return $this->connection->delete($this->table, ['id' => $id]);
    }
}
