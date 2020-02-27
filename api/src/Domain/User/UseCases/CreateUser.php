<?php
declare(strict_types=1);

namespace App\Domain\User\UseCases;

use App\Domain\User\Exceptions\UserNotFoundException;
use App\Domain\User\Service\PasswordHasherInterface;
use App\Domain\User\User;
use App\Domain\User\UserRepository;
use App\Infrastructure\Doctrine\Flusher;
use App\Domain\User\Inputs\CreateInput;

class CreateUser
{
    private UserRepository $userRepository;
    private Flusher $flusher;
    private PasswordHasherInterface $hasher;

    public function __construct(
        UserRepository $userRepository,
        Flusher $flusher,
        PasswordHasherInterface $hasher
    )
    {
        $this->userRepository = $userRepository;
        $this->flusher = $flusher;
        $this->hasher = $hasher;
    }

    public function handle(CreateInput $createInput)
    {
        if ($this->userRepository->hasByEmail($createInput->email)) {
            throw new UserNotFoundException('User with this email already exists.');
        }

        $user = new User(
            $createInput->email,
            $this->hasher->hash($createInput->password),
            $createInput->role
        );

        $this->userRepository->add($user);
        $this->flusher->flush();
    }
}
