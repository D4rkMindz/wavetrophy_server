<?php

namespace App\Service\UUID;


class UUID
{
    public static function generate()
    {
        return uniqid('wt', true);
    }
}
