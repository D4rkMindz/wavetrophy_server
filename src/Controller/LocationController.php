<?php


namespace App\Controller;


use App\Factory\MapURLFactory;
use App\Repository\LocationRepository;
use App\Service\Response\JSONResponse;
use App\Service\Validation\LocationValidation;
use Interop\Container\Exception\ContainerException;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class LocationController
 */
class LocationController extends AppController
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @var LocationValidation
     */
    private $locationValidation;

    /**
     * LocationController constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->locationRepository = $container->get(LocationRepository::class);
        $this->locationValidation = $container->get(LocationValidation::class);
    }

    /**
     * Create Location.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return ResponseInterface
     */
    public function createLocationAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $wavetrophyHash = $args['wavetrophy_hash'];
        $roadGroupHash = $args['road_group_hash'];

        $json = $request->getBody()->__toString();
        $data = json_decode($json, true);
        $zipcode = array_value('zipcode', $data);
        $name = array_value('name', $data);
        $street = array_value('street', $data);
        $city = array_value('city', $data);
        $lat = array_value('lat', $data);
        $lon = array_value('lon', $data);
        $additionalStops = array_value('additional_stops', $data);

        $description = array_value('description', $data);

        $validationContext = $this->locationValidation->validateCreation(
            $wavetrophyHash,
            $roadGroupHash,
            $name,
            $street,
            $city,
            $zipcode,
            $lat,
            $lon,
            $description
        );
        if ($validationContext->fails()) {
            return $this->errorFromValidationContext($response, $validationContext);
        }

        $androidURL = MapURLFactory::createForAndroid($lat, $lon, $additionalStops);
        $iosURL = MapURLFactory::createForiOS($lat, $lon, $additionalStops);

        $hash = $this->locationRepository->createLocation(
            $this->jwt['user_hash'],
            $wavetrophyHash,
            $roadGroupHash,
            $name,
            $city,
            $street,
            $zipcode,
            $lat,
            $lon,
            $androidURL,
            $iosURL,
            $description
        );

        $responseData = JSONResponse::success(['location_hash' => $hash]);

        return $this->json($response, $responseData);
    }
}
