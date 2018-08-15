<?php

namespace App\Table;

use Cake\Database\Connection;
use Cake\Database\Query;
use Cake\Database\StatementInterface;

/**
 * Class AppTable.
 */
abstract class AppTable
{
    // TODO reimplement TableInterface
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
     * @param bool $includeArchived
     * @return Query
     */
    public function newSelect(bool $includeArchived = false): Query
    {
        if ($includeArchived) {
            return $this->connection->newQuery()->from($this->table);
        }
        return $this->connection->newQuery()->from($this->table)->where(
            [
                'OR' => [
                    [$this->table . '.archived_at >= ' => date('Y-m-d H:i:s')],
                    [$this->table . '.archived_at IS NULL'],
                ]
            ]
        );
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTablename()
    {
        return $this->table;
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
     * @param string $userHash
     * @return string The last inserted hash.
     */
    public function insert(array $row, string $userHash): string
    {
        $row['created_at'] = date('Y-m-d H:i:s');
        $row['created_by'] = $userHash;
        $inserted = $this->connection->insert($this->table, $row);
        if ($inserted) {
            return array_value('hash', $row) ?: true;
        }
        return null;
    }

    /**
     * Update database.
     *
     * @param array $row
     * @param array $where The where condition
     * @param string $userHash
     * @return StatementInterface
     */
    public function modify(array $row, array $where,string $userHash): StatementInterface
    {
        $row['modified_at'] = date('Y-m-d H:i:s');
        $row['modified_by'] = $userHash;
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
