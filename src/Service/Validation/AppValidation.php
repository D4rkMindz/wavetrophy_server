<?php


namespace App\Service\Validation;


use App\Util\ValidationContext;

class AppValidation
{
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
}
