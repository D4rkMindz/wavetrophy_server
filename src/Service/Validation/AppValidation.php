<?php


namespace App\Service\Validation;


use App\Repository\EventRepository;
use App\Repository\GroupRepository;
use App\Repository\LocationRepository;
use App\Repository\TrophyRepository;
use App\Repository\UserRepository;
use App\Util\ValidationContext;
use Interop\Container\Exception\ContainerException;
use Slim\Container;

class AppValidation
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var TrophyRepository
     */
    private $trophyRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * LocationValidation constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->userRepository = $container->get(UserRepository::class);
        $this->trophyRepository = $container->get(TrophyRepository::class);
        $this->groupRepository = $container->get(GroupRepository::class);
        $this->locationRepository = $container->get(LocationRepository::class);
        $this->eventRepository = $container->get(EventRepository::class);
    }

    /**
     * Assert that value is not empty.
     *
     * @param $value
     * @param string $fieldname
     * @param ValidationContext $validationContext
     */
    protected function assertNotEmpty($value, string $fieldname, ValidationContext $validationContext)
    {
        if (empty($value)) {
            $validationContext->setError($fieldname, __('Can not be empty'));
        }
    }

    /**
     * Assert that string has a minimum length.
     *
     * @param string $value
     * @param string $fieldname
     * @param int $minLength
     * @param ValidationContext $validationContext
     */
    protected function assertStringMinLength(string $value, string $fieldname, int $minLength, ValidationContext $validationContext)
    {
        if (strlen(trim($value)) < $minLength) {
            $validationContext->setError($fieldname, sprintf(__('Minimum length is %s'), $minLength));
        }
    }

    /**
     * Assert that string has a minimum length.
     *
     * @param string $value
     * @param string $fieldname
     * @param int $maxLength
     * @param ValidationContext $validationContext
     */
    protected function assertStringMaxLength(string $value, string $fieldname, int $maxLength, ValidationContext $validationContext)
    {
        if (strlen(trim($value)) > $maxLength) {
            $validationContext->setError($fieldname, sprintf(__('Maximum length is %s'), $maxLength));
        }
    }

    /**
     * Validate wavetrophy hash.
     *
     * @param string $wavetrophyHash
     * @param ValidationContext $validationContext
     */
    protected function validateWavetrophyHash(string $wavetrophyHash, ValidationContext $validationContext)
    {
        $trophyExists = $this->trophyRepository->existsTrophy($wavetrophyHash);
        if (!$trophyExists) {
            $validationContext->setError('wavetrophy_hash', __('Wavetrophy does not exist'));
        }
    }

    /**
     * Validate road group hash.
     *
     * @param string $roadGroupHash
     * @param ValidationContext $validationContext
     */
    protected function validateRoadGroupHash(string $roadGroupHash, ValidationContext $validationContext)
    {
        $groupExists = $this->groupRepository->existsGroup($roadGroupHash);
        if (!$groupExists) {
            $validationContext->setError('road_group_hash', __('Road group does not exist'));
        }
    }

    /**
     * Validate location hash.
     *
     * @param string $locationHash
     * @param ValidationContext $validationContext
     */
    protected function validateLocationHash(string $locationHash, ValidationContext $validationContext)
    {
        $locationExists = $this->locationRepository->existsLocation($locationHash);
        if (!$locationExists) {
            $validationContext->setError('location_hash', __('Location does not exist'));
        }
    }

    /**
     * Validate Event hash.
     *
     * @param string $EventHash
     * @param ValidationContext $validationContext
     */
    protected function validateEventHash(string $EventHash, ValidationContext $validationContext)
    {
        $EventExists = $this->eventRepository->existsEvent($EventHash);
        if (!$EventExists) {
            $validationContext->setError('Event_hash', __('Event does not exist'));
        }
    }
}
