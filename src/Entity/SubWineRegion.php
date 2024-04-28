<?php

namespace App\Entity;

use App\Repository\SubWineRegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubWineRegionRepository::class)]
class SubWineRegion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'subWineRegions')]
    private ?WineRegion $wineregion = null;

    #[ORM\OneToMany(mappedBy: 'subwineregion', targetEntity: Appellation::class)]
    private Collection $appellations;

    public function __construct()
    {
        $this->appellations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getWineregion(): ?WineRegion
    {
        return $this->wineregion;
    }

    public function setWineregion(?WineRegion $wineregion): static
    {
        $this->wineregion = $wineregion;

        return $this;
    }

    /**
     * @return Collection<int, Appellation>
     */
    public function getAppellations(): Collection
    {
        return $this->appellations;
    }

    public function addAppellation(Appellation $appellation): static
    {
        if (!$this->appellations->contains($appellation)) {
            $this->appellations->add($appellation);
            $appellation->setSubwineregion($this);
        }

        return $this;
    }

    public function removeAppellation(Appellation $appellation): static
    {
        if ($this->appellations->removeElement($appellation)) {
            // set the owning side to null (unless already changed)
            if ($appellation->getSubwineregion() === $this) {
                $appellation->setSubwineregion(null);
            }
        }

        return $this;
    }
}
