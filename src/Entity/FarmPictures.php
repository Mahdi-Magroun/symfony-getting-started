<?php

namespace App\Entity;

use App\Repository\FarmPicturesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FarmPicturesRepository::class)
 */
class FarmPictures
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Farm::class, inversedBy="farmPictures")
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    private $farm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFarm(): ?Farm
    {
        return $this->farm;
    }

    public function setFarm(?Farm $farm): self
    {
        $this->farm = $farm;

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
