<?php


namespace App\Repository\Exception;


use Exception;
use Throwable;

class EmptySetException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
