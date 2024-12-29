<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $totalOrder = null;

    #[ORM\Column(length: 255)]
    private ?string $paymentMethod = null;

    #[ORM\Column(length: 255)]
    private ?string $deliveryMethod = null;

    /**
     * @var Collection<int, OrderDetailsLine>
     */
    #[ORM\ManyToMany(targetEntity: OrderDetailsLine::class, inversedBy: 'orders')]
    private Collection $line;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    public function __construct()
    {
        $this->line = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalOrder(): ?float
    {
        return $this->totalOrder;
    }

    public function setTotalOrder(float $totalOrder): static
    {
        $this->totalOrder = $totalOrder;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getDeliveryMethod(): ?string
    {
        return $this->deliveryMethod;
    }

    public function setDeliveryMethod(string $deliveryMethod): static
    {
        $this->deliveryMethod = $deliveryMethod;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetailsLine>
     */
    public function getLine(): Collection
    {
        return $this->line;
    }

    public function addLine(OrderDetailsLine $line): static
    {
        if (!$this->line->contains($line)) {
            $this->line->add($line);
        }

        return $this;
    }

    public function removeLine(OrderDetailsLine $line): static
    {
        $this->line->removeElement($line);

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }
}
