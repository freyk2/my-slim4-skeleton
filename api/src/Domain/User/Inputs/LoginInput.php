<?php
declare(strict_types=1);

namespace App\Domain\User\Inputs;

use Symfony\Component\Validator\Constraints as Assert;

class LoginInput
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @Assert\NotBlank()
     */
    public $password;
}
