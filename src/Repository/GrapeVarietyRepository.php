<?php

namespace App\Repository;

use App\Entity\GrapeVariety;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GrapeVariety>
 *
 * @method GrapeVariety|null find($id, $lockMode = null, $lockVersion = null)
 * @method GrapeVariety|null findOneBy(array $criteria, array $orderBy = null)
 * @method GrapeVariety[]    findAll()
 * @method GrapeVariety[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrapeVarietyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GrapeVariety::class);
    }

    public function transform(GrapeVariety $grapevariety)
    {
        return [
            'id' => (int) $grapevariety->getId(),
            'name' => (string)$grapevariety->getName(),
        ];
    }

    public function transformAll()
    {
        $grapevarietys = $this->findAll();
        $grapevarietyCollection = [];

        foreach ($grapevarietys as $grapevariety) {
            $grapevarietyCollection[] = $this->transform($grapevariety);
        }

        return $grapevarietyCollection;
    }
}
