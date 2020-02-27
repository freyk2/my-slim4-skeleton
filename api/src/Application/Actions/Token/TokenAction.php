<?php
declare(strict_types=1);

namespace App\Application\Actions\Token;

use App\Domain\User\Inputs\LoginInput;
use App\Domain\User\UseCases\GenerateToken;
use App\Infrastructure\Validator\ValidationException;
use App\Infrastructure\Validator\Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Laminas\Diactoros\Response\JsonResponse;

class TokenAction
{
    private GenerateToken $tokenHandler;
    private Validator $validator;

    public function __construct(GenerateToken $tokenHandler, Validator $validator)
    {
        $this->tokenHandler = $tokenHandler;
        $this->validator = $validator;
    }

    public function handle(Request $request): Response
    {
        $input = $this->deserialize($request);

        if ($errors = $this->validator->validate($input)) {
            throw new ValidationException($errors);
        }

        $token = $this->tokenHandler->handle($input);

        return new JsonResponse([
            'token' => $token->getToken(),
            'expires' => $token->getExpires()
        ],201);
    }

    private function deserialize(Request $request): LoginInput
    {
        $body = $request->getParsedBody();

        $input = new LoginInput();

        $input->email = $body['email'] ?? '';
        $input->password = $body['password'] ?? '';

        return $input;
    }

}
