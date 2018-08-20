<?php


namespace App\Service\Validation;


use App\Repository\GroupRepository;
use App\Repository\TrophyRepository;
use App\Repository\UserRepository;
use App\Util\ValidationContext;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

class LocationValidation extends AppValidation
{
    public function validateCreation(
        string $wavetrophyHash,
        string $roadGroupHash,
        string $name,
        string $street,
        string $city,
        string $zipcode,
        string $lat,
        string $lon,
        ?string $description
    )
    {
        $validationContext = new ValidationContext(__('Location information invalid'));
        $this->validateWavetrophyHash($wavetrophyHash, $validationContext);
        $this->validateRoadGroupHash($roadGroupHash, $validationContext);
        $this->validateName($name, $validationContext);
        $this->validateCity($city, $validationContext);
        $this->validateStreet($street, $validationContext);
        $this->validateZipcode($zipcode, $validationContext);
        $this->validateLatLon($lat, $lon, $validationContext);
        if (!empty($description)) {
            $this->validateDescription($description, $validationContext);
        }
        return $validationContext;
    }

    /**
     * Validate deletion of a location
     *
     * @param string $wavetrophyHash
     * @param string $roadGroupHash
     * @param string $locationHash
     * @return ValidationContext
     */
    public function validateDeletion(string $wavetrophyHash, string $roadGroupHash, string $locationHash)
    {
        $validationContext = new ValidationContext(__('Deleting location failed'));
        $this->validateWavetrophyHash($wavetrophyHash, $validationContext);
        $this->validateRoadGroupHash($roadGroupHash, $validationContext);
        $this->validateLocationHash($locationHash, $validationContext);
        return $validationContext;
    }

    /**
     * Validate name.
     *
     * @param string $name
     * @param ValidationContext $validationContext
     */
    private function validateName(string $name, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($name, 'name', $validationContext);
        $this->assertStringMinLength($name, 'name', 3, $validationContext);
        $this->assertStringMaxLength($name, 'name', 45, $validationContext);
    }

    /**
     * Validate city.
     *
     * @param string $city
     * @param ValidationContext $validationContext
     */
    private function validateCity(string $city, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($city, 'city', $validationContext);
        $this->assertStringMinLength($city, 'city', 3, $validationContext);
        $this->assertStringMaxLength($city, 'city', 255, $validationContext);
    }

    /**
     * Validate street.
     *
     * @param string $street
     * @param ValidationContext $validationContext
     */
    private function validateStreet(string $street, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($street, 'street', $validationContext);
        $this->assertStringMinLength($street, 'street', 3, $validationContext);
        $this->assertStringMaxLength($street, 'street', 255, $validationContext);
    }

    /**
     * Validate zip code.
     * 
     * @param string $zipCode
     * @param ValidationContext $validationContext
     * @todo maybe validate zipcode against zipcode table (in combination with name)
     */
    private function validateZipcode(string $zipCode, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($zipCode, 'zipcode', $validationContext);
        $this->assertStringMinLength($zipCode, 'zipcode', 3, $validationContext);
        $this->assertStringMaxLength($zipCode, 'zipcode', 10, $validationContext);
    }

    /**
     * Validate lat/lon coordinates
     * 
     * @param string $lat
     * @param string $lon
     * @param ValidationContext $validationContext
     */
    private function validateLatLon(string $lat, string $lon, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($lat, 'lat', $validationContext);
        $this->assertNotEmpty($lon, 'lon', $validationContext);
    }

    /**
     * Validate description.
     *
     * @param string $description
     * @param ValidationContext $validationContext
     */
    private function validateDescription(string $description, ValidationContext $validationContext)
    {
        $this->assertStringMinLength($description, 'description', 10, $validationContext);
        $this->assertStringMaxLength($description, 'description', 1000, $validationContext);
    }

}
