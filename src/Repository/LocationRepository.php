<?php


namespace App\Repository;


use App\Service\UUID\UUID;
use App\Table\AddressImageTable;
use App\Table\AddressTable;
use App\Table\ImageTable;
use App\Util\Formatter;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

class LocationRepository extends AppRepository
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
     * LocationRepository constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->addressTable = $container->get(AddressTable::class);
        $this->imageTable = $container->get(ImageTable::class);
        $this->addressImageTable = $container->get(AddressImageTable::class);
    }

    /**
     * Create location
     *
     * @param string $userHash
     * @param string $wavetrophyHash
     * @param string $roadGroupHash
     * @param string $name
     * @param string $city
     * @param string $street
     * @param string $zipcode
     * @param string $lat
     * @param string $lon
     * @param string $mapUrlAndroid
     * @param string $mapUrlIos
     * @param array $images
     * @param null|string $description
     * @return string
     */
    public function createLocation(
        string $userHash,
        string $wavetrophyHash,
        string $roadGroupHash,
        string $name,
        string $city,
        string $street,
        string $zipcode,
        string $lat,
        string $lon,
        string $mapUrlAndroid,
        string $mapUrlIos,
        array $images,
        ?string $description
    )
    {
        $row = [
            'hash' => UUID::generate(),
            'wavetrophy_hash' => $wavetrophyHash,
            'road_group_hash' => $roadGroupHash,
            'name' => $name,
            'city' => $city,
            'street' => $street,
            'zipcode' => $zipcode,
            'coordinate_lat' => $lat,
            'coordinate_lon' => $lon,
            'map_url_android' => $mapUrlAndroid,
            'map_url_ios' => $mapUrlIos,
        ];
        if (!empty($description)) {
            $row['description'] = $description;
        }

        $locationHash = $this->addressTable->insert($row, $userHash);
        if (!empty($images)) {
            foreach ($images as $image) {
                $imageRow = [
                    'hash' => UUID::generate(),
                    'url' => $image,
                ];
                $imageHash = $this->imageTable->insert($imageRow, $userHash);
                $addressImageRow = [
                    'image_hash' => $imageHash,
                    'address_hash' => $locationHash,
                ];
                $this->addressImageTable->insert($addressImageRow, $userHash);
            }
        }
        return $locationHash;
    }

    /**
     * Check if location (address) exists.
     *
     * @param string $locationHash
     * @return bool
     */
    public function existsLocation(string $locationHash)
    {
        return $this->exists($this->imageTable, ['hash' => $locationHash]);
    }

    /**
     * Archive location
     *
     * @param string $locationHash
     * @param string $userHash
     * @return bool
     */
    public function archiveLocation(string $locationHash, string $userHash)
    {
        return $this->addressTable->archive($locationHash, $userHash);
    }
}
