<?php
declare(strict_types=1);

namespace App\Domain\User\Inputs;

use Symfony\Component\Validator\Constraints as Assert;

class CreateInput
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=6)
     */
    public $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"App\Domain\User\User", "getAllRoles"})
     */
    public $role;
}
