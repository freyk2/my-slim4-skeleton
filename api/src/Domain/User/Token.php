<?php
declare(strict_types=1);

namespace App\Domain\User;

class Token
{
    private string $token;
    private int $expires;

    public function __construct(string $token, int $expires)
    {
        $this->token = $token;
        $this->expires = $expires;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getExpires(): int
    {
        return $this->expires;
    }

    public function setExpires(int $expires): void
    {
        $this->expires = $expires;
    }

}