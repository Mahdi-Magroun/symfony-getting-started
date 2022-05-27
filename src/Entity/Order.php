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
     * @ORM\JoinColumn(nullable=true)
     */
    private $farm;

    /**
     * @ORM\ManyToOne(targetEntity=Greengrocer::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=true)
     */
    private $greengrocer;

    /**
     * @ORM\OneToMany(targetEntity=Items::class, mappedBy="ordor",cascade={"persist", "remove"})
     */
    private $items;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    
    /**
     * @ORM\Column(type="boolean")
     */
    private $isDelivered;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPrepared;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $should_delevered_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $delivred_at;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFarm(): ?Farm
    {
        return $this->farm;
    }

    public function setFarm(?Farm $farmer): self
    {
        $this->farm = $farmer;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getShouldDeleveredAt(): ?\DateTimeInterface
    {
        return $this->should_delevered_at;
    }

    public function setShouldDeleveredAt(\DateTimeInterface $should_delevered_at): self
    {
        $this->should_delevered_at = $should_delevered_at;

        return $this;
    }

    public function isIsDelivered(): ?bool
    {
        return $this->isDelivered;
    }

    public function setIsDelivered(bool $isDelivered): self
    {
        $this->isDelivered = $isDelivered;

        return $this;
    }

    public function isIsPrepared(): ?bool
    {
        return $this->isPrepared;
    }

    public function setIsPrepared(bool $isPrepared): self
    {
        $this->isPrepared = $isPrepared;

        return $this;
    }

    public function getDelivredAt(): ?\DateTimeInterface
    {
        return $this->delivred_at;
    }

    public function setDelivredAt(?\DateTimeInterface $delivred_at): self
    {
        $this->delivred_at = $delivred_at;

        return $this;
    }
}
