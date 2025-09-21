<?php

declare(strict_types=1);

namespace App\Core\Repository;

use App\Core\Repository\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryProxy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template T of object
 * @template-extends ServiceEntityRepositoryProxy<T>
 *
 * @psalm-api
 */
abstract class DoctrineRepository extends ServiceEntityRepositoryProxy
{
    /** @var class-string<T> */
    public string $entityClass;

    /**
     * @psalm-suppress PossiblyUnusedParam
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->entityClass);
    }

    /**
     * @phpstan-param 0|1|2|4|null $lockMode
     * @psalm-param LockMode::*|null $lockMode
     * @psalm-suppress PossiblyUnusedParam
     *
     * @throws EntityNotFoundException
     *
     * @psalm-return T
     * @phpstan-return T
     */
    public function get(string $id, ?int $lockMode = null, ?int $lockVersion = null): object
    {
        if (!$object = $this->find($id, $lockMode, $lockVersion)) {
            throw new EntityNotFoundException(
                sprintf('%s with id "%s" is not found', $this->entityClass, $id)
            );
        }

        return $object;
    }

    /**
     * @psalm-return T
     * @phpstan-return T
     */
    public function getRandom(): ?object
    {
        $object = $this->createQueryBuilder('e')
            ->orderBy('random()')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$object) {
            throw new EntityNotFoundException(
                sprintf('%s not found', $this->entityClass)
            );
        }

        return $object;
    }

    /**
     * @phpstan-param T $entity
     * @psalm-suppress PossiblyUnusedParam
     */
    public function save(object $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->flush();
        }
    }

    /**
     * @psalm-suppress PossiblyUnusedParam
     */
    public function remove(object $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->flush();
        }
    }

    protected function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
