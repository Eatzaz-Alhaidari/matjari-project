<?php

namespace App\Services\Floosak;

use RuntimeException;

class FloosakPaymentException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly int $httpStatus = 422,
        public readonly array $errors = []
    ) {
        parent::__construct($message, $httpStatus);
    }
}
