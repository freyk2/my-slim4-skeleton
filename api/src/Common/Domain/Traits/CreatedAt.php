<?php
declare(strict_types=1);

namespace App\Common\Domain\Traits;


use DateTimeImmutable;

trait CreatedAt
{
    /**
     * @ORM\Column(type="datetime_immutable", name="created_at")
     */
    protected DateTimeImmutable $createdAt;

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    protected function onCreated(): void
    {
        $this->createdAt = new DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }
}
