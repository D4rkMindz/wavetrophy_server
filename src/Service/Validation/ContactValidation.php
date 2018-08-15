<?php


namespace App\Service\Validation;


use App\Repository\TrophyRepository;
use App\Table\TrophyTable;
use App\Util\ValidationContext;
use Interop\Container\Exception\ContainerException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Slim\Container;

class ContactValidation extends AppValidation
{
    const FIELD_NAME_WAVETROPHY = 'wavetrophy';
    const FIELD_NAME_POSITION = 'position';
    const FIELD_NAME_PHONENUMBER = 'phonenumber';
    const FIELD_NAME_FIRSTNAME = 'firstname';
    const FIELD_NAME_LASTNAME = 'lastname';
    const FIELD_NAME_EMAIL = 'email';

    /**
     * @var TrophyRepository
     */
    private $wavetrophyRepository;

    /**
     * ContactValidation constructor.
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->wavetrophyRepository = $container->get(TrophyRepository::class);
    }

    /**
     * Validate the creation of a contact.
     *
     * @param string $wavetrophyHash
     * @param string $position
     * @param string $phonenumber
     * @param string $firstname
     * @param string $lastname
     * @param null|string $email
     * @return ValidationContext
     */
    public function validateCreation(string $wavetrophyHash, string $position, string $phonenumber, string $firstname, string $lastname, ?string $email)
    {
        $validationContext = new ValidationContext(__('Contact information invalid'));

        $this->validateWavetrophy($wavetrophyHash, $validationContext);
        $this->validatePosition($position, $validationContext);
        $this->validatePhonenumber($phonenumber, $validationContext);
        $this->validateFirstname($firstname, $validationContext);
        $this->validateLastname($lastname, $validationContext);
        $this->validateEmail($email, $validationContext);

        return $validationContext;
    }

    /**
     * Validate wavetrophy.
     *
     * @param string $wavetrophyHash
     * @param ValidationContext $validationContext
     */
    private function validateWavetrophy(string $wavetrophyHash, ValidationContext $validationContext)
    {
        $exists = $this->wavetrophyRepository->existsTrophy($wavetrophyHash);
        if (!$exists) {
            $validationContext->setError(self::FIELD_NAME_WAVETROPHY, __('Wavetrophy does not exist'));
        }
    }

    /**
     * Validate the position of a contact.
     * 
     * @param string $position
     * @param ValidationContext $validationContext
     */
    private function validatePosition(string $position, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($position, self::FIELD_NAME_POSITION, $validationContext);
        $this->assertStringMinLength($position, self::FIELD_NAME_POSITION, 5, $validationContext);
        $this->assertStringMaxLength($position, self::FIELD_NAME_POSITION, 20, $validationContext);
    }

    /**
     * Validate the phonenumber of the contact.
     *
     * @param string $phonenumber
     * @param ValidationContext $validationContext
     */
    private function validatePhonenumber(string $phonenumber, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($phonenumber, self::FIELD_NAME_PHONENUMBER, $validationContext);
        $phonenumberUtil = PhoneNumberUtil::getInstance();
        try {
            $phoneNumberObject = $phonenumberUtil->parse($phonenumber, null);
        } catch (NumberParseException $e) {
            $invalid = true;
        }
        if (!$phonenumberUtil->isPossibleNumber($phoneNumberObject) || $invalid) {
            $validationContext->setError(self::FIELD_NAME_PHONENUMBER, __('Phonenumber is not valid'));
        }
    }

    /**
     * Validate first name.
     *
     * @param string $firstname
     * @param ValidationContext $validationContext
     */
    private function validateFirstname(string $firstname, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($firstname, self::FIELD_NAME_FIRSTNAME, $validationContext);
        $this->assertStringMinLength($firstname, self::FIELD_NAME_FIRSTNAME, 2, $validationContext);
        $this->assertStringMaxLength($firstname, self::FIELD_NAME_FIRSTNAME, 80, $validationContext);
    }

    /**
     * Validate last name.
     *
     * @param string $lastname
     * @param ValidationContext $validationContext
     */
    private function validateLastname(string $lastname, ValidationContext $validationContext)
    {
        $this->assertNotEmpty($lastname, self::FIELD_NAME_LASTNAME, $validationContext);
        $this->assertStringMinLength($lastname, self::FIELD_NAME_LASTNAME, 2, $validationContext);
        $this->assertStringMaxLength($lastname, self::FIELD_NAME_LASTNAME, 80, $validationContext);
    }

    /**
     * Validate email.
     *
     * This method allows also empty emails.
     *
     * @param string $email
     * @param ValidationContext $validationContext
     */
    private function validateEmail(string $email, ValidationContext $validationContext)
    {
        if (empty($email)) {
            // allow empty email
            return;
        }

        if (!is_email($email)){
            $validationContext->setError(self::FIELD_NAME_EMAIL, __('Email is not valid'));
        }
    }
}
