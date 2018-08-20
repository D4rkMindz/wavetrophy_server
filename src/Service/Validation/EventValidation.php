<?php

namespace App\Service\Validation;


use App\Util\ValidationContext;

class EventValidation extends AppValidation
{
    /**
     * Validate creation of an event.
     *
     * @param string $wavetrophyHash
     * @param string $groupHash
     * @param string $locationHash
     * @param string $title
     * @param string $description
     * @param $start
     * @param $end
     * @param int $day
     * @return ValidationContext
     */
    public function validateCreation(
        string $wavetrophyHash,
        string $groupHash,
        string $locationHash,
        string $title,
        string $description,
        $start,
        $end,
        int $day
    )
    {
        $validationContext = new ValidationContext(__('Event information invalid'));
        $this->validateWavetrophyHash($wavetrophyHash, $validationContext);
        $this->validateRoadGroupHash($groupHash, $validationContext);
        $this->validateLocationHash($locationHash, $validationContext);
        $this->validateTitle($title, $validationContext);
        $this->validateDescription($description, $validationContext);
        $this->validateStartAndEnd($start, $end, $validationContext);
        $this->validateDay($day, $validationContext);
        return $validationContext;
    }

    /**
     * Validate deletion of a location
     *
     * @param string $wavetrophyHash
     * @param string $roadGroupHash
     * @param string $locationHash
     * @param string $eventHash
     * @return ValidationContext
     */
    public function validateDeletion(string $wavetrophyHash, string $roadGroupHash, string $locationHash, string $eventHash)
    {
        $validationContext = new ValidationContext(__('Deleting event failed'));
        $this->validateWavetrophyHash($wavetrophyHash, $validationContext);
        $this->validateRoadGroupHash($roadGroupHash, $validationContext);
        $this->validateLocationHash($locationHash, $validationContext);
        $this->validateEventHash($eventHash, $validationContext);
        return $validationContext;
    }

    /**
     * Validate event title.
     * 
     * @param string $title
     * @param ValidationContext $validationContext
     */
    private function validateTitle(string $title, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($title, 'title', $validationContext);
        $this->assertStringMinLength($title, 'title', 3, $validationContext);
        $this->assertStringMaxLength($title, 'title', 45, $validationContext);
    }

    /**
     * Validate description.
     *
     * @param string $description
     * @param ValidationContext $validationContext
     */
    private function validateDescription(string $description, ValidationContext $validationContext)
    {
        if (!empty($description)) {
            $this->assertStringMinLength($description, 'description', 10, $validationContext);
            $this->assertStringMaxLength($description, 'description', 1000, $validationContext);
        }
    }

    /**
     * Validate dates.
     *
     * @param $start
     * @param $end
     * @param ValidationContext $validationContext
     */
    private function validateStartAndEnd($start, $end, ValidationContext $validationContext)
    {
        $startTime = strtotime($start);
        $endTime = strtotime($end);
        $this->assertNotEmpty($start, 'start', $validationContext);
        if ($startTime > $endTime) {
            $validationContext->setError('start', __('Start can not be before end'));
        }
    }

    /**
     * Validate day
     *
     * @param $day
     * @param ValidationContext $validationContext
     */
    private function validateDay($day, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($day, 'day', $validationContext);
    }
}
