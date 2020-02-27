<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;


class ValidationException extends \LogicException
{
    private $errors;

    public function __construct(Errors $errors)
    {
        parent::__construct('Ошибка валидации');
        $this->errors = $errors;
    }

    public function getErrors(): Errors
    {
        return $this->errors;
    }
}
