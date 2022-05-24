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
    private $farm;

    /**
     * @ORM\ManyToOne(targetEntity=Greengrocer::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
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
}
