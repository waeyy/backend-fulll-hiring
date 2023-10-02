<?php

declare(strict_types=1);

namespace Fulll\App\Command;

class CreateFleet
{
    public function __construct(public readonly string $userId)
    {
    }
}
