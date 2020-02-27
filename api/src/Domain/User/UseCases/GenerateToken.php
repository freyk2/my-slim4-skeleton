<?php
declare(strict_types=1);

namespace App\Domain\User\UseCases;

use App\Domain\User\Exceptions\UserNotFoundException;
use App\Domain\User\Inputs\LoginInput;
use App\Domain\User\Token;
use App\Domain\User\UserRepository;
use App\Infrastructure\Services\BCryptPasswordHasher;
use Firebase\JWT\JWT;

class GenerateToken
{
    private UserRepository $userRepository;
    private BCryptPasswordHasher $hasher;

    public function __construct(UserRepository $userRepository, BCryptPasswordHasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    public function handle(LoginInput $input): Token
    {
        $user = $this->userRepository->getByEmail($input->email);

        if (!$user || !$this->hasher->validate($input->password, $user->getPasswordHash())) {
            throw new UserNotFoundException('Пользователь не найден или пароль не совпадает');
        }

        $now = new \DateTime();
        $future = new \DateTime("now +" . $_ENV['TOKEN_MINUTES'] . " minutes");

        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "userId" => $user->getId()
        ];

        $secret = $_ENV["JWT_SECRET"];
        $token = JWT::encode($payload, $secret, "HS256");

        return new Token($token, $future->getTimeStamp());
    }
}
