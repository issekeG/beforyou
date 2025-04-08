<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'formation_image', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): static
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?FormationCategory $category = null;

    /**
     * @var Collection<int, FormationSection>
     */
    #[ORM\OneToMany(targetEntity: FormationSection::class, mappedBy: 'formation',cascade: ["persist", "remove"])]
    private Collection $formationSections;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endedAt = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $publishedAt = null;

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    public function __construct()
    {

        $this->formationSections = new ArrayCollection();
        $this->publishedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?FormationCategory
    {
        return $this->category;
    }

    public function setCategory(?FormationCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, FormationSection>
     */
    public function getFormationSections(): Collection
    {
        return $this->formationSections;
    }

    public function addFormationSection(FormationSection $formationSection): static
    {
        if (!$this->formationSections->contains($formationSection)) {
            $this->formationSections->add($formationSection);
            $formationSection->setFormation($this);
        }

        return $this;
    }

    public function removeFormationSection(FormationSection $formationSection): static
    {
        if ($this->formationSections->removeElement($formationSection)) {
            // set the owning side to null (unless already changed)
            if ($formationSection->getFormation() === $this) {
                $formationSection->setFormation(null);
            }
        }

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlug(): void
    {
        if ($this->title) {
            $slugify = new Slugify();
            $slug = $slugify->slugify($this->title);

            $dateTime = new \DateTimeImmutable();
            $formattedDate = $dateTime->format('Y-m-d_H-i-s');

            $this->slug = $slug . '-' . $formattedDate;
        }
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

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->endedAt;
    }

    public function setEndedAt(\DateTimeInterface $endedAt): static
    {
        $this->endedAt = $endedAt;

        return $this;
    }
}
