<?php

namespace App\Service\Validation;


use App\Util\ValidationContext;

/**
 * Class GroupValidation
 */
class GroupValidation extends AppValidation
{
    /**
     * Validate group creation.
     *
     * @param string $wavetrophyHash
     * @param string $name
     * @return ValidationContext
     */
    public function validateCreation(string $wavetrophyHash, ?string $name)
    {
        $validationContext = new ValidationContext(__('Group information invalid'));
        $this->validateWavetrophyHash($wavetrophyHash, $validationContext);
        $this->validateName($validationContext, $name);
        return $validationContext;
    }

    public function validateUpdate(?string $name)
    {
        $validationContext = new ValidationContext(__('Group information invalid'));
        $this->validateName($validationContext, $name);
        return $validationContext;
    }

    /**
     * Validate deletion of a location
     *
     * @param string $wavetrophyHash
     * @param string $roadGroupHash
     * @return ValidationContext
     */
    public function validateDeletion(string $wavetrophyHash, string $roadGroupHash)
    {
        $validationContext = new ValidationContext(__('Deleting event failed'));
        $this->validateWavetrophyHash($wavetrophyHash, $validationContext);
        $this->validateRoadGroupHash($roadGroupHash, $validationContext);
        return $validationContext;
    }

    /**
     * Validate group name.
     *
     * @param string $name
     * @param ValidationContext $validationContext
     */
    private function validateName(ValidationContext $validationContext, ?string $name)
    {
        $this->assertNotEmpty($name, 'name', $validationContext);
        $this->assertStringMinLength($name, 'name', 3, $validationContext);
        $this->assertStringMaxLength($name, 'name', 255, $validationContext);
    }
}
