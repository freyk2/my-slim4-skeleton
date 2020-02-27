<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine;


interface FlusherInterface
{
    public function flush($entity): void;
}
