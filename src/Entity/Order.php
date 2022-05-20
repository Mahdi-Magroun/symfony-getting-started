<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Farm::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $farmer;

    /**
     * @ORM\ManyToOne(targetEntity=Greengrocer::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $greengrocer;

    /**
     * @ORM\OneToMany(targetEntity=Items::class, mappedBy="ordor")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFarmer(): ?Farm
    {
        return $this->farmer;
    }

    public function setFarmer(?Farm $farmer): self
    {
        $this->farmer = $farmer;

        return $this;
    }

    public function getGreengrocer(): ?Greengrocer
    {
        return $this->greengrocer;
    }

    public function setGreengrocer(?Greengrocer $greengrocer): self
    {
        $this->greengrocer = $greengrocer;

        return $this;
    }

    /**
     * @return Collection<int, Items>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Items $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setOrdor($this);
        }

        return $this;
    }

    public function removeItem(Items $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrdor() === $this) {
                $item->setOrdor(null);
            }
        }

        return $this;
    }
}
