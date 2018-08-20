<?php


namespace App\Repository;


use App\Service\UUID\UUID;
use App\Table\AddressTable;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

class LocationRepository extends AppRepository
{
    /**
     * @var AddressTable
     */
    private $addressTable;

    /**
     * LocationRepository constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->addressTable = $container->get(AddressTable::class);
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

        return $this->addressTable->insert($row, $userHash);
    }
}
