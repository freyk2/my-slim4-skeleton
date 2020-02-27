<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\Outputs\UserOutput;
use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Laminas\Diactoros\Response\JsonResponse;

class ListUsersAction extends UserAction
{
    public function handle(Request $request): Response
    {
        $users = $this->userRepository->getAll();
        $users = array_map(fn(User $user) => UserOutput::from($user), $users);

        return new JsonResponse($users);
    }
}
