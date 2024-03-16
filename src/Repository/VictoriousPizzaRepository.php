<?php

namespace App\Repository;

use App\Entity\VictoriousPizza;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VictoriousPizza>
 *
 * @method VictoriousPizza|null find($id, $lockMode = null, $lockVersion = null)
 * @method VictoriousPizza|null findOneBy(array $criteria, array $orderBy = null)
 * @method VictoriousPizza[]    findAll()
 * @method VictoriousPizza[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VictoriousPizzaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VictoriousPizza::class);
    }

    public function transform(VictoriousPizza $pizza)
    {
        return [
                'id' => (int) $pizza->getId(),
                'name' => (string )$pizza->getName(),
        ];
    }

    public function transformAll()
    {
        $pizzas = $this->findAll();
        $pizzaCollection = [];

        foreach ($pizzas as $pizza) {
            $pizzaCollection[] = $this->transform($pizza);
        }

        return $pizzaCollection;
    }

}
