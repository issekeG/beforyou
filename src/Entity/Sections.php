<?php

namespace App\Entity;

use App\Repository\SectionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: SectionsRepository::class)]
#[Broadcast]
#[Vich\Uploadable]
class Sections
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 350, nullable: true)]
    private ?string $photo = null;

    #[Vich\UploadableField(mapping: 'sections_image', fileNameProperty: 'photo')]
    #[Assert\Image()]
    private ?File $photoFile = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'sections')]
    private ?Posts $posts = null;

    public function __toString(): string
    {
        return $this->title ?? 'Section sans titre';
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPosts(): ?Posts
    {
        return $this->posts;
    }

    public function setPosts(?Posts $posts): static
    {
        $this->posts = $posts;

        return $this;
    }

    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    public function setPhotoFile(?File $photoFile): static
    {
        $this->photoFile = $photoFile;

        return $this;
    }


}
