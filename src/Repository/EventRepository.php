<?php


namespace App\Repository;


use App\Service\UUID\UUID;
use App\Table\EventImageTable;
use App\Table\EventTable;
use App\Table\ImageTable;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

class EventRepository extends AppRepository
{
    /**
     * @var EventTable
     */
    private $eventTable;

    /**
     * @var EventImageTable
     */
    private $eventImageTable;

    /**
     * @var ImageTable
     */
    private $imageTable;

    /**
     * EventRepository constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->eventTable = $container->get(EventTable::class);
        $this->eventImageTable = $container->get(EventImageTable::class);
        $this->imageTable = $container->get(ImageTable::class);
    }

    public function createEvent(
        string $userHash,
        string $roadGroupHash,
        string $locationHash,
        string $title,
        string $description,
        string $start,
        string $end,
        string $day,
        array $images
    )
    {
        $row = [
            'hash' => UUID::generate(),
            'group_hash' => $roadGroupHash,
            'address_hash' => $locationHash,
            'title' => $title,
            'description' => $description,
            'start' => $start,
            'end' => $end,
            'day' => $day,
        ];
        $eventHash = $this->eventTable->insert($row, $userHash);
        if (!empty($images)) {
            foreach ($images as $image) {
                $imageRow = [
                    'hash' => UUID::generate(),
                    'url' => $image,
                ];
                $imageHash = $this->imageTable->insert($imageRow, $userHash);
                $eventImageRow = [
                    'event_hash' => $eventHash,
                    'image_hash' => $imageHash,
                ];
                $this->eventImageTable->insert($eventImageRow, $userHash);
            }
        }
        return $eventHash;
    }

    /**
     * Exists event.
     *
     * @param string $eventHash
     * @return bool
     */
    public function existsEvent(string $eventHash)
    {
        return $this->exists($this->eventTable, ['hash' => $eventHash]);
    }

    /**
     * Archive event.
     *
     * @param string $userHash
     * @param string $eventHash
     * @return bool
     */
    public function archiveEvent(string $userHash, string $eventHash)
    {
        return $this->eventTable->archive($eventHash,$userHash);
    }
}
