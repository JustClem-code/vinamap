<?php

namespace App\Repository;

use App\Entity\Appellation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appellation>
 *
 * @method Appellation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appellation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appellation[]    findAll()
 * @method Appellation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppellationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appellation::class);
    }

    public function getGrapeCollection($ap) {
        $grapevariety = $ap->getGrapevariety();
        $grapeCollection = [];

        foreach ($grapevariety as $grape) {
            $grapeCollection[] = [
                'grapevarietyId' => $grape->getId(),
                'grapevarietyName' => $grape->getName(),
            ];
        }

        return $grapeCollection;
    }

    public function transform(Appellation $appellation)
    {
        return [
            'id' => (int) $appellation->getId(),
            'name' => (string) $appellation->getName(),
            'wineregionId' => (int) $appellation->getWineregion()?->getId(),
            'wineregionName' => (string) $appellation->getWineregion()?->getName(),
            'subwineregionId' => (int) $appellation->getSubwineregion()?->getId(),
            'subwineregionName' => (string) $appellation->getSubwineregion()?->getName(),
            'grapevarietyCollection' => (array) $this->getGrapeCollection($appellation),
        ];
    }

    public function transformAll()
    {
        $appellations = $this->findAll();
        $appellationCollection = [];

        foreach ($appellations as $appellation) {
            $appellationCollection[] = $this->transform($appellation);
        }

        return $appellationCollection;
    }
}
