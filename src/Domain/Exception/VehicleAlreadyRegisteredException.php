<?php

declare(strict_types=1);

namespace Fulll\Domain\Exception;

class VehicleAlreadyRegisteredException extends \RuntimeException
{
    public function __construct(
        string $message = 'Vehicle already registered',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
