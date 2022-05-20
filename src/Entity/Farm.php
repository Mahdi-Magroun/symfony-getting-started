<?php

namespace App\Entity;

use App\Repository\FarmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FarmRepository::class)
 */
class Farm
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $farm_name;

    /**
     * @ORM\Column(type="text")
     */
    private $loacation;

   

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="Farm")
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="myfarm", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="farmer")
     */
    private $orders;

    public function __construct()
    
    {
        $this->products = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFarmName(): ?string
    {
        return $this->farm_name;
    }

    public function setFarmName(string $farm_name): self
    {
        $this->farm_name = $farm_name;

        return $this;
    }

    public function getLoacation(): ?string
    {
        return $this->loacation;
    }

    public function setLoacation(string $loacation): self
    {
        $this->loacation = $loacation;

        return $this;
    }

    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): self
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setFarm($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
          
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setFarmer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getFarmer() === $this) {
                $order->setFarmer(null);
            }
        }

        return $this;
    }
}
