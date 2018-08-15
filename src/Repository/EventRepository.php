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

    /**
     * EventRepository constructor.
     * @param Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        $this->eventTable = $container->get(EventTable::class);
    }
}
