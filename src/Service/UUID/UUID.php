<?php

namespace App\Service\UUID;


use Ramsey\Uuid\Uuid as UniversalUniqueIdentifier;

class UUID
{
    public static function generate()
    {
        return UniversalUniqueIdentifier::uuid4();
    }
}
