<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

interface PasswordHasherInterface
{
    public function hash(string $password): string;

    public function validate(string $password, string $hash): bool;
}
