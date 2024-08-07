<?php

namespace App\Entity;

use App\Repository\WineRegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: WineRegionRepository::class)]
#[UniqueEntity(
    'name',
    message: 'This wine region already exist!'
)]
class WineRegion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'wineregion', targetEntity: Appellation::class)]
    private Collection $appellations;

    #[ORM\OneToMany(mappedBy: 'wineregion', targetEntity: SubWineRegion::class)]
    private Collection $subWineRegions;

    public function __construct()
    {
        $this->appellations = new ArrayCollection();
        $this->subWineRegions = new ArrayCollection();
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
            $appellation->setWineregion($this);
        }

        return $this;
    }

    public function removeAppellation(Appellation $appellation): static
    {
        if ($this->appellations->removeElement($appellation)) {
            // set the owning side to null (unless already changed)
            if ($appellation->getWineregion() === $this) {
                $appellation->setWineregion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SubWineRegion>
     */
    public function getSubWineRegions(): Collection
    {
        return $this->subWineRegions;
    }

    public function addSubWineRegion(SubWineRegion $subWineRegion): static
    {
        if (!$this->subWineRegions->contains($subWineRegion)) {
            $this->subWineRegions->add($subWineRegion);
            $subWineRegion->setWineregion($this);
        }

        return $this;
    }

    public function removeSubWineRegion(SubWineRegion $subWineRegion): static
    {
        if ($this->subWineRegions->removeElement($subWineRegion)) {
            // set the owning side to null (unless already changed)
            if ($subWineRegion->getWineregion() === $this) {
                $subWineRegion->setWineregion(null);
            }
        }

        return $this;
    }
}
