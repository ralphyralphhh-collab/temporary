<?php

namespace App\Repository;

use App\Entity\MerchStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MerchStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MerchStock::class);
    }

    /**
     * @return array<string, string> product => price, e.g. ['bottle' => '150.00']
     */
    public function findAllPrices(): array
    {
        $rows = $this->createQueryBuilder('m')
            ->select('m.product', 'm.price')
            ->getQuery()
            ->getResult();

        $prices = [];
        foreach ($rows as $row) {
            $prices[$row['product']] = $row['price'];
        }

        return $prices;
    }
}
