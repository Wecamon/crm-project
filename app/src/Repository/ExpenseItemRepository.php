<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ExpenseItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpenseItem>
 *
 * @method ExpenseItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpenseItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpenseItem[] findAll()
 * @method ExpenseItem[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpenseItem::class);
    }
}
