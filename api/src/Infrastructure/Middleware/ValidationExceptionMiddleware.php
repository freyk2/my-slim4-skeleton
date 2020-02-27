<?php
declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\Infrastructure\Validator\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ValidationException $exception){
            return new JsonResponse([
                'errors' => $exception->getErrors()->toArray()
            ], 400);
        }
    }
}
