<?php

namespace App\Repository;

use App\Entity\WineRegion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WineRegion>
 *
 * @method WineRegion|null find($id, $lockMode = null, $lockVersion = null)
 * @method WineRegion|null findOneBy(array $criteria, array $orderBy = null)
 * @method WineRegion[]    findAll()
 * @method WineRegion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WineRegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WineRegion::class);
    }

    public function transform(WineRegion $wineregion)
    {
        return [
            'id' => (int) $wineregion->getId(),
            'name' => (string)$wineregion->getName(),
        ];
    }

    public function transformAll()
    {
        $wineregions = $this->findAll();
        $wineregionCollection = [];

        foreach ($wineregions as $wineregion) {
            $wineregionCollection[] = $this->transform($wineregion);
        }

        return $wineregionCollection;
    }
}
