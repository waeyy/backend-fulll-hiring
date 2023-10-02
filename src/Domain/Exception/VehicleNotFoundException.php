<?php

declare(strict_types=1);

namespace Fulll\Domain\Exception;

class VehicleNotFoundException extends \RuntimeException
{
    public function __construct(
        string $message = 'Vehicle not found.',
        int $code = 404,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
