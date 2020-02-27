<?php
declare(strict_types=1);

namespace App\Common\Domain\Traits;

use Ramsey\Uuid\Uuid;

trait Entity
{
    /**
     * @ORM\Column(type="uuid")
     * @ORM\Id
     */
    protected Uuid $id;

    public function getId(): string
    {
        return $this->id->toString();
    }

    protected function identify(): void
    {
        $this->id = Uuid::uuid4();
    }
}
