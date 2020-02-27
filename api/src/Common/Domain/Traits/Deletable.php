<?php
declare(strict_types=1);

namespace App\Common\Domain\Traits;


trait Deletable
{
    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $isDeleted = false;

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function delete(): void
    {
        $this->isDeleted = true;
    }

    public function rise(): void
    {
        $this->isDeleted = false;
    }
}
