<?php

declare(strict_types=1);

namespace Fulll\Domain\Exception;

class VehicleAlreadyParkedAtThisLocationException extends \RuntimeException
{
    public function __construct(
        string $message = 'Vehicle already parked at the given location.',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
