<?php


namespace App\Repository;


use App\Table\EventTable;
use Slim\Container;

class EventRepository extends AppRepository
{
    /**
     * @var EventTable
     */
    private $eventTable;

    public function __construct(Container $container)
    {
        $this->eventTable = $container->get(EventTable::class);
    }

    public function getAllOrderedByLocation($waveHash, $groupHash)
    {
        $query = $this->eventTable->newSelect();
        $fields = [];
        $query->select($fields)
            ->where([])
            // TODO continue here
    }
}
