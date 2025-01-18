<?php

namespace App\Entity;

use App\Repository\TestimonyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: TestimonyRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Testimony
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $clientName = null;

    #[ORM\Column(length: 255)]
    private ?string $clientPosition = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $testimonyAt = null;

    #[ORM\Column(length: 300, nullable: true)]
    private ?string $videoLink = null;

    #[ORM\Column(length: 300)]
    private ?string $clientPhoto = null;

    #[Vich\UploadableField(mapping: 'client_image', fileNameProperty: 'clientPhoto')]
    private ?File $clientPhotoFile = null;

    public function getClientPhotoFile(): ?File
    {
        return $this->clientPhotoFile;
    }

    public function setClientPhotoFile(?File $clientPhotoFile): static
    {
        $this->clientPhotoFile = $clientPhotoFile;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): static
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getClientPosition(): ?string
    {
        return $this->clientPosition;
    }

    public function setClientPosition(string $clientPosition): static
    {
        $this->clientPosition = $clientPosition;

        return $this;
    }

    public function getTestimonyAt(): ?\DateTimeInterface
    {
        return $this->testimonyAt;
    }

    public function setTestimonyAt(\DateTimeInterface $testimonyAt): static
    {
        $this->testimonyAt = $testimonyAt;

        return $this;
    }

    public function getVideoLink(): ?string
    {
        return $this->videoLink;
    }

    public function setVideoLink(?string $videoLink): static
    {
        $this->videoLink = $videoLink;

        return $this;
    }

    public function getClientPhoto(): ?string
    {
        return $this->clientPhoto;
    }

    public function setClientPhoto(string $clientPhoto): static
    {
        $this->clientPhoto = $clientPhoto;

        return $this;
    }
}
