<?php

namespace App\Repository;

use App\Entity\SubWineRegion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SubWineRegion>
 *
 * @method SubWineRegion|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubWineRegion|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubWineRegion[]    findAll()
 * @method SubWineRegion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubWineRegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubWineRegion::class);
    }

    public function transform(SubWineRegion $subwineregion)
    {
        return [
            'id' => (int) $subwineregion->getId(),
            'name' => (string) $subwineregion->getName(),
            'wineregionId' => (int) $subwineregion->getWineregion()?->getId(),
            'wineregionName' => (string) $subwineregion->getWineregion()?->getName(),
        ];
    }

    public function transformAll()
    {
        $subwineregions = $this->findAll();
        $subwineregionCollection = [];

        foreach ($subwineregions as $subwineregion) {
            $subwineregionCollection[] = $this->transform($subwineregion);
        }

        return $subwineregionCollection;
    }
}
