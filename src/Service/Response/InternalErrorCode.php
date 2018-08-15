<?php

namespace App\Service\Response;


class InternalErrorCode
{
    const ELEMENT_NOT_FOUND = 1; // A request gets an empty response because the requested element does not exist
    const VALUE_NOT_VALID = 2; // An input value is not valid an can not be processed
}
