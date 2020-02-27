<?php
declare(strict_types=1);

namespace App\Domain\User\Outputs;


use App\Domain\User\User;

class UserOutput
{
    public string $id;
    public string $email;
    public string $role;
    public bool $status;

    public static function from(User $user): self
    {
        $output = new self();

        $output->id = $user->getId();
        $output->email = $user->getEmail();
        $output->role = $user->getRole();
        $output->status = $user->getStatus();

        return $output;
    }
}