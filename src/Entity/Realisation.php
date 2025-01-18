<?php

namespace App\Entity;

use App\Repository\RealisationRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RealisationRepository::class)]
#[ORM\HasLifecycleCallbacks]

class Realisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $client = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startedAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryAt = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $subTitle = null;

    #[ORM\Column(length: 500)]
    private ?string $subTitle2 = null;

    public function getSubTitle2(): ?string
    {
        return $this->subTitle2;
    }

    public function setSubTitle2(?string $subTitle2): static
    {
        $this->subTitle2 = $subTitle2;

        return $this;
    }

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $subTitleDescription = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $secondSubTitleDescription= null;

    /**
     * @var Collection<int, Images>
     */
    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'realisation',cascade: ["persist", "remove"])]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'realisations')]
    private ?Activity $activity = null;


    #[ORM\Column(length: 500)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getDeliveryAt(): ?\DateTimeInterface
    {
        return $this->deliveryAt;
    }

    public function setDeliveryAt(?\DateTimeInterface $deliveryAt): static
    {
        $this->deliveryAt = $deliveryAt;

        return $this;
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): static
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    public function getSubTitleDescription(): ?string
    {
        return $this->subTitleDescription;
    }

    public function setSubTitleDescription(?string $subTitleDescription): static
    {
        $this->subTitleDescription = $subTitleDescription;

        return $this;
    }

    public function getSecondSubTitleDescription(): ?string
    {
        return $this->secondSubTitleDescription;
    }

    public function setSecondSubTitleDescription(?string $secondSubTitleDescription): static
    {
        $this->secondSubTitleDescription = $secondSubTitleDescription;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setRealisation($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getRealisation() === $this) {
                $image->setRealisation(null);
            }
        }

        return $this;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlug(): void
    {
        if ($this->title && !$this->slug) {
            $slugify = new Slugify();
            $slug = $slugify->slugify($this->title);

            $dateTime = new \DateTimeImmutable();
            $formattedDate = $dateTime->format('Y-m-d_H-i-s');

            $this->slug = $slug . '-' . $formattedDate;
        }
    }



}
