<?php


namespace App\Repository;


use App\Table\AddressImageTable;
use App\Table\AddressTable;
use App\Table\EventImageTable;
use App\Table\EventTable;
use App\Table\ImageTable;
use App\Util\Formatter;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

/**
 * Class StreamRepository
 */
class StreamRepository
{
    /**
     * @var AddressTable
     */
    private $addressTable;

    /**
     * @var AddressImageTable
     */
    private $addressImageTable;

    /**
     * @var ImageTable
     */
    private $imageTable;

    /**
     * @var EventTable
     */
    private $eventTable;

    /**
     * @var EventImageTable
     */
    private $eventImageTable;

    /**
     * StreamRepository constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->addressTable = $container->get(AddressTable::class);
        $this->addressImageTable = $container->get(AddressImageTable::class);
        $this->imageTable = $container->get(ImageTable::class);
        $this->eventTable = $container->get(EventTable::class);
        $this->eventImageTable = $container->get(EventImageTable::class);
    }

    /**
     * @param string $wavetrophyHash
     * @param string $roadGroupHash
     * @return array
     */
    public function getStreamForGroup(string $wavetrophyHash, string $roadGroupHash): array
    {
        $addressTablename = $this->addressTable->getTablename();

        $fields = [
            'hash' => $addressTablename . '.hash',
            'title' => $addressTablename . '.name',
            'description' => $addressTablename . '.description',
            'address_url_android' => $addressTablename . '.map_url_android',
            'address_url_ios' => $addressTablename . '.map_url_ios',
            'address_lat' => $addressTablename . '.coordinate_lat',
            'address_lon' => $addressTablename . '.coordinate_lon',
            'address_city' => $addressTablename . '.city',
            'address_zip' => $addressTablename . '.zipcode',
            'address_street' => $addressTablename . '.street',
            'address_comment' => $addressTablename . '.comment',
        ];
        $query = $this->addressTable->newSelect();
        $query->select($fields)->where([$addressTablename . '.wavetrophy_hash' => $wavetrophyHash, $addressTablename . '.road_group_hash' => $roadGroupHash]);
        $rows = $query->execute()->fetchAll('assoc');
        $locations = [];
        foreach ($rows as $location) {
            $location = Formatter::formatLocation($location);
            $location['images'] = $this->getImagesForLocation($location['hash']);
            $location['events'] = $this->getEventsForLocation($location['hash'], $roadGroupHash);
            $locations[] = $location;
        }
        return $locations;
    }

    /**
     * Get Events for location.
     *
     * @param string $addressHash
     * @param string $roadGroupHash
     * @return array
     */
    private function getEventsForLocation(string $addressHash, string $roadGroupHash): array
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

    /**
     * Get images for location.
     *
     * @param string $addressHash
     * @return array
     */
    private function getImagesForLocation(string $addressHash): array
    {
        $imageTablename = $this->imageTable->getTablename();
        $addressImageTablename = $this->addressImageTable->getTablename();

        $query = $this->addressImageTable->newSelect();
        $query->select([$imageTablename . '.url'])
            ->where([$addressImageTablename . '.address_hash' => $addressHash])
            ->join([
                [
                    'table' => $imageTablename,
                    'type' => 'LEFT',
                    'conditions' => $imageTablename . '.hash = ' . $addressImageTablename . '.image_hash',
                ],
            ]);
        $rows = $query->execute()->fetchAll('assoc');
        // Placeholder image in app. TODO move placeholder image to server and download/cache it in the application.
        return $rows ?: ['assets/imgs/placeholder.png'];
    }
}
