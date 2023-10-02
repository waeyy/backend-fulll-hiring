<?php

declare(strict_types=1);

namespace Fulll\Domain\Exception;

class FleetNotFoundException extends \RuntimeException
{
    public function __construct(
        string $message = 'Fleet not found.',
        int $code = 404,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
