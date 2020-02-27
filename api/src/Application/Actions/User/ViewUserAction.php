<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\Outputs\UserOutput;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Laminas\Diactoros\Response\JsonResponse;

class ViewUserAction extends UserAction
{
    public function handle(Request $request, Response $response, $args): Response
    {
        $userId = $args['id'];
        $user = $this->userRepository->getById($userId);

        return new JsonResponse(UserOutput::from($user));
    }
}
