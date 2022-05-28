<?php

namespace App\Entity;

use App\Repository\GreengrocerPictureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GreengrocerPictureRepository::class)
 */
class GreengrocerPicture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Greengrocer::class, inversedBy="greengrocerPictures")
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    private $greengrocer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
