<?php
declare(strict_types=1);

namespace App\Common\Domain\Traits;


use DateTimeImmutable;

trait UpdatedAt
{
    /**
     * @ORM\Column(type="datetime_immutable", name="updated_at", nullable=true)
     */
    protected DateTimeImmutable $updatedAt;

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    protected function onUpdated()
    {
        $this->updatedAt = new DateTimeImmutable('now');
    }
}
