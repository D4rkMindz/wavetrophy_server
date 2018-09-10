<?php


namespace App\Repository;


use App\Service\UUID\UUID;
use App\Table\EventImageTable;
use App\Table\EventTable;
use App\Table\ImageTable;
use App\Util\Formatter;
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

    /**
     * Get all events
     *
     * @param string $roadGroupHash
     * @param string $addressHash
     * @return array
     */
    public function getAllEvents(string $roadGroupHash, string $addressHash)
    {
        $query = $this->eventTable->newSelect();
        $fields = [
            'hash',
            'day',
            'start',
            'end',
            'title',
            'description',
        ];
        $query->select($fields)->where(['group_hash' => $roadGroupHash, 'address_hash' => $addressHash]);
        $rows = $query->execute()->fetchAll('assoc');
        if (empty($rows)) {
            return [];
        }
        foreach ($rows as $key => $event) {
            $rows[$key] = Formatter::formatEvent($event);
            $rows[$key]['images'] = $this->getImagesForEvent($event['hash']);
        }
        return $rows;
    }

    /**
     * Create event
     *
     * @param string $userHash
     * @param string $roadGroupHash
     * @param string $locationHash
     * @param string $title
     * @param string $description
     * @param string $start
     * @param string $end
     * @param string $day
     * @param array $images
     * @return string
     */
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
                    'url' => $image['url'],
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



    /**
     * Get images for event.
     *
     * @param string $eventHash
     * @return array
     */
    private function getImagesForEvent(string $eventHash): array
    {
        $imageTablename = $this->imageTable->getTablename();
        $eventImageTablename = $this->eventImageTable->getTablename();

        $query = $this->eventImageTable->newSelect();
        $query->select([$imageTablename . '.url'])
            ->where([$eventImageTablename . '.event_hash' => $eventHash])
            ->join([
                [
                    'table' => $imageTablename,
                    'type' => 'LEFT',
                    'conditions' => $imageTablename . '.hash = ' . $eventImageTablename . '.image_hash',
                ],
            ]);
        $rows = $query->execute()->fetchAll('assoc');
        // Placeholder image in app. TODO move placeholder image to server and download/cache it in the application.
        return $rows ?: ['assets/imgs/placeholder.png'];
    }
}
