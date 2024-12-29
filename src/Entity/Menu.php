<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $regularPrice = null;

    #[ORM\Column]
    private ?float $dealPercentage = null;

    #[ORM\Column]
    private ?float $dealPrice = null;

    #[ORM\Column(length: 500)]
    private ?string $imagepath = null;

    #[ORM\Column]
    private ?int $quantityStock = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\ManyToMany(targetEntity: Item::class, inversedBy: 'menus')]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getRegularPrice(): ?float
    {
        return $this->regularPrice;
    }

    public function setRegularPrice(float $regularPrice): self
    {
        $this->regularPrice = $regularPrice;

        return $this;
    }

    public function getDealPercentage(): ?float
    {
        return $this->dealPercentage;
    }

    public function setDealPercentage(float $dealPercentage): self
    {
        $this->dealPercentage = $dealPercentage;

        return $this;
    }

    public function getDealPrice(): ?float
    {
        return $this->dealPrice;
    }

    public function setDealPrice(float $dealPrice): self
    {
        $this->dealPrice = $dealPrice;

        return $this;
    }

    public function getImagepath(): ?string
    {
        return $this->imagepath;
    }

    public function setImagepath(string $imagepath): static
    {
        $this->imagepath = $imagepath;

        return $this;
    }

    public function getQuantityStock(): ?int
    {
        return $this->quantityStock;
    }

    public function setQuantityStock(int $quantityStock): static
    {
        $this->quantityStock = $quantityStock;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        $this->items->removeElement($item);

        return $this;
    }
}
