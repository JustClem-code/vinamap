<?php

namespace App\Entity;

use App\Repository\AppellationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AppellationRepository::class)]
#[UniqueEntity(
    'name',
    message: 'This appellation already exist!'
)]
class Appellation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'appellations')]
    private ?WineRegion $wineregion = null;

    #[ORM\ManyToMany(targetEntity: GrapeVariety::class, inversedBy: 'appellations')]
    private Collection $grapevariety;

    #[ORM\ManyToOne(inversedBy: 'appellations')]
    private ?SubWineRegion $subwineregion = null;

    #[ORM\OneToMany(mappedBy: 'Appellation', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->grapevariety = new ArrayCollection();
        $this->products = new ArrayCollection();
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
     * @return Collection<int, GrapeVariety>
     */
    public function getGrapevariety(): Collection
    {
        return $this->grapevariety;
    }

    public function addGrapevariety(GrapeVariety $grapevariety): static
    {
        if (!$this->grapevariety->contains($grapevariety)) {
            $this->grapevariety->add($grapevariety);
        }

        return $this;
    }

    public function removeGrapevariety(GrapeVariety $grapevariety): static
    {
        $this->grapevariety->removeElement($grapevariety);

        return $this;
    }

    public function getSubwineregion(): ?SubWineRegion
    {
        return $this->subwineregion;
    }

    public function setSubwineregion(?SubWineRegion $subwineregion): static
    {
        $this->subwineregion = $subwineregion;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setAppellation($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getAppellation() === $this) {
                $product->setAppellation(null);
            }
        }

        return $this;
    }
}
