<?php
declare(strict_types=1);

namespace App\Domain\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $generatedRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->generatedRepository = $entityManager->getRepository(User::class);
    }

    public function hasByEmail(string $email): bool
    {
        return $this->generatedRepository->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.email = :email')
                ->setParameter(':email', $email)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function getByEmail($email): ?User
    {
        return $this->generatedRepository->findOneBy(['email' => $email, 'status' => true]);
    }

    public function getAll(): ?array
    {
        return $this->generatedRepository->findAll();
    }

    public function getById(string $id): ?User
    {
        return $this->generatedRepository->find($id);
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }
}