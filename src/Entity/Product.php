<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity=Farm::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Farm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $product_name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $product_discription;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

   

    public function __construct()
    {
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFarm(): ?Farm
    {
        return $this->Farm;
    }

    public function setFarm(Farm $farm): self
    {
        $this->Farm = $farm;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): self
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getProductDiscription(): ?string
    {
        return $this->product_discription;
    }

    public function setProductDiscription(?string $product_discription): self
    {
        $this->product_discription = $product_discription;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    

  
}
