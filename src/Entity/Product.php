<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $Manufacturer = null;

    #[ORM\Column(nullable: true)]
    private ?int $Vintage = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Appellation $Appellation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Review = null;

    #[ORM\ManyToOne(inversedBy: 'user_email')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_email = null;

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

    public function getManufacturer(): ?string
    {
        return $this->Manufacturer;
    }

    public function setManufacturer(string $Manufacturer): static
    {
        $this->Manufacturer = $Manufacturer;

        return $this;
    }

    public function getVintage(): ?int
    {
        return $this->Vintage;
    }

    public function setVintage(?int $Vintage): static
    {
        $this->Vintage = $Vintage;

        return $this;
    }

    public function getAppellation(): ?Appellation
    {
        return $this->Appellation;
    }

    public function setAppellation(?Appellation $Appellation): static
    {
        $this->Appellation = $Appellation;

        return $this;
    }

    public function getReview(): ?string
    {
        return $this->Review;
    }

    public function setReview(?string $Review): static
    {
        $this->Review = $Review;

        return $this;
    }

    public function getUserEmail(): ?User
    {
        return $this->user_email;
    }

    public function setUserEmail(?User $user_email): static
    {
        $this->user_email = $user_email;

        return $this;
    }

}
