<?php

declare(strict_types=1);

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Domain\User\Service\PasswordHasherInterface;
use App\Infrastructure\Services\BCryptPasswordHasher;

return [
    ValidatorInterface::class => static function () {
        AnnotationRegistry::registerLoader('class_exists');
        return Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    },

    PasswordHasherInterface::class => static function() {
        return new BCryptPasswordHasher();
    }

];
