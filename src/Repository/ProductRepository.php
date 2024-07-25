<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;


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
    public function __construct(
        ManagerRegistry $registry,
        private Security $security,
    ) {
        parent::__construct($registry, Product::class);
    }


    public function transform(Product $product)
    {
        return [
            'id' => (int) $product->getId(),
            'name' => (string) $product->getName(),
            'appellationId' => (int) $product->getappellation()?->getId(),
            'appellationName' => (string) $product->getappellation()?->getName(),
            'manufacturer' => (string) $product->getManufacturer(),
            'vintage' => (int) $product->getVintage(),
            'review' => (string) $product->getReview(),
            'userEmail' => $product->getUserEmail()->getId(),
        ];
    }

    public function getUserId(User $user) 
    {
        return (int) $user->getId();
    }

    public function transformAll()
    {
        $user = $this->security->getUser();

        $userId = $this->getUserId($user);

        $products = $this->findBy(
            ['user_email' => $userId]
        );
        
        $productCollection = [];

        foreach ($products as $product) {
            $productCollection[] = $this->transform($product);
        }

        return $productCollection;
    }
}
