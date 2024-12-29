<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 500)]
    private ?string $imagepath = null;

    #[ORM\Column]
    private ?int $quantityStock = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, Menu>
     */
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'items')]
    private Collection $menus;

    /**
     * @var Collection<int, OrderDetailsLine>
     */
    #[ORM\OneToMany(targetEntity: OrderDetailsLine::class, mappedBy: 'item')]
    private Collection $orderDetailsLines;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->orderDetailsLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): static
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->addItem($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): static
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeItem($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderDetailsLine>
     */
    public function getOrderDetailsLines(): Collection
    {
        return $this->orderDetailsLines;
    }

    public function addOrderDetailsLine(OrderDetailsLine $orderDetailsLine): static
    {
        if (!$this->orderDetailsLines->contains($orderDetailsLine)) {
            $this->orderDetailsLines->add($orderDetailsLine);
            $orderDetailsLine->setItem($this);
        }

        return $this;
    }

    public function removeOrderDetailsLine(OrderDetailsLine $orderDetailsLine): static
    {
        if ($this->orderDetailsLines->removeElement($orderDetailsLine)) {
            // set the owning side to null (unless already changed)
            if ($orderDetailsLine->getItem() === $this) {
                $orderDetailsLine->setItem(null);
            }
        }

        return $this;
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
}
