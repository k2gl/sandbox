<?php

namespace App\Repository;

use App\Core\Repository\DoctrineRepository;
use App\Entity\OrangeGnome;

/**
 * @extends DoctrineRepository<OrangeGnome>
 *
 * @method OrangeGnome      get(string $id, ?int $lockMode = null, ?int $lockVersion = null)
 * @method OrangeGnome|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrangeGnome|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrangeGnome[]    findAll()
 * @method OrangeGnome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrangeGnomeRepository extends DoctrineRepository
{
    public string $entityClass = OrangeGnome::class;
}
