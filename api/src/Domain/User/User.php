<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Common\Domain\Traits\CreatedAt;
use Doctrine\ORM\Mapping as ORM;
use App\Common\Domain\Traits\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name="users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"email"})
 * })
 */
class User
{
    use Entity, CreatedAt;

    const ROLE_ADMIN = 'admin';
    const ROLE_EMPLOYER = 'employer';

    /**
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string")
     */
    private string $role;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $status = false;

    public function __construct(
        string $email,
        string $password,
        string $role
    )
    {
        $this->identify();
        $this->onCreated();

        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->status = false;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getPasswordHash(): string
    {
        return $this->password;
    }

    public function activate(): void
    {
        $this->status = true;
    }

    public function isActive(): bool
    {
        return $this->status === true;
    }

    public static function getAllRoles(): array
    {
        $reflector = new \ReflectionClass(self::class);
        $allConstants = $reflector->getConstants();
        $roles = array_filter($allConstants, function ($key){
            return preg_match('/(^|\A|\s|\-)ROLE_.*?(\s|$|\Z|\-)/', $key);
        }, ARRAY_FILTER_USE_KEY);

        return array_values($roles);
    }

}