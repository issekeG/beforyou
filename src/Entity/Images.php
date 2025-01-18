<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'realisation_image', fileNameProperty: 'image')]
    #[Assert\Image()]
    private ?File $image_file = null;

    public function getImageFile(): ?File
    {
        return $this->image_file;
    }

    public function setImageFile(?File $image_file): static
    {
        $this->image_file = $image_file;

        return $this;

    }

    #[ORM\Column(length: 255)]
    #[Assert\Choice(['principale', 'secondaire','moyenne', 'petite','affiche'])]
    private ?string $dimension = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Realisation $realisation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    public function setDimension(string $dimension): static
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function getRealisation(): ?Realisation
    {
        return $this->realisation;
    }

    public function setRealisation(?Realisation $realisation): static
    {
        $this->realisation = $realisation;

        return $this;
    }
}
