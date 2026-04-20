<?php

namespace App\Services\Floosak;

use RuntimeException;
use Throwable;

class FloosakApiException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly int $httpStatus = 0,
        public readonly ?array $payload = null,
        public readonly bool $retryable = false,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $httpStatus, $previous);
    }
}
