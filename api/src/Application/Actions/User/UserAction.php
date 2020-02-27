<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\UserRepository;

abstract class UserAction
{
    public UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
