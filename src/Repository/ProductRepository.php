<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    public function transform(Product $product)
    {
        return [
            'id' => (int) $product->getId(),
            'name' => (string) $product->getName(),
            'appellationId' => (int) $product->getappellation()?->getId(),
            'appellationName' => (string) $product->getappellation()?->getName(),
        ];
    }

    public function transformAll()
    {
        $products = $this->findAll();
        $productCollection = [];

        foreach ($products as $product) {
            $productCollection[] = $this->transform($product);
        }

        return $productCollection;
    }
}
