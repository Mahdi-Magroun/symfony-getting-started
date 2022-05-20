<?php

namespace App\Entity;

use App\Repository\GreengrocerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GreengrocerRepository::class)
 */
class Greengrocer
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
    private $greengrocer_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="greengrocer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="greengrocer")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGreengrocerName(): ?string
    {
        return $this->greengrocer_name;
    }

    public function setGreengrocerName(string $greengrocer_name): self
    {
        $this->greengrocer_name = $greengrocer_name;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOwnerId(): ?User
    {
        return $this->owner_id;
    }

    public function setOwnerId(User $owner_id): self
    {
        $this->owner_id = $owner_id;

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
            $order->setGreengrocer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getGreengrocer() === $this) {
                $order->setGreengrocer(null);
            }
        }

        return $this;
    }
}
