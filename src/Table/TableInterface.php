<?php
/**
 * Created by PhpStorm.
 * User: bjoern.pfoster
 * Date: 18.12.2017
 * Time: 09:31.
 */

namespace App\Table;

use Cake\Database\Connection;
use Cake\Database\Query;
use Cake\Database\StatementInterface;

/**
 * Interface ModelInterface.
 */
interface TableInterface
{
    /**
     * AppTable constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection = null);

    /**
     * Get table name.
     *
     * @return string table name
     */
    public function getTablename();

    /**
     * Get all entries from database.
     *
     * @return array $rows
     */
    public function getAll(): array;

    /**
     * Get Query.
     *
     * @return Query
     */
    public function newSelect(): Query;

    /**
     * Get entity by id.
     *
     * @param $hash
     * @return array
     */
    public function getByHash(string $hash): array;

    /**
     * Insert into database.
     *
     * @param array $row with data to insertUser into database
     * @param string $userHash
     * @return StatementInterface last inserted ID
     */
    public function insert(array $row, string $userHash): string;

    /**
     * Update database
     *
     * @param array $row
     * @param array $where should be the id
     * @param string $userHash
     * @return StatementInterface
     */
    public function modify(array $row, array $where, string $userHash): StatementInterface;

    /**
     * Delete from database.
     *
     * @param string $userHash
     * @param array $where
     * @return bool
     */
    public function archive(string $hash, string $userHash): bool;

//    /**
//     * Unarchive element.
//     *
//     * @param string $executorId
//     * @param array $where
//     * @return bool true if unarchived successfully
//     */
//    public function unarchive(string $executorId, array $where): bool;
//
//    /**
//     * Check if table has not metadata like created, modified and archived information.
//     *
//     * @return bool
//     */
//    public function hasMetadata(): bool;
}
