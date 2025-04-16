<?php

namespace App\Entity;

use App\Repository\FormationSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationSectionRepository::class)]
class FormationSection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'formationSections')]
    private ?Formation $formation = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, FormationCategory>
     */
    #[ORM\OneToMany(targetEntity: FormationCategory::class, mappedBy: 'section')]
    private Collection $formationCategories;

    public function __construct()
    {
        $this->formationCategories = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, FormationCategory>
     */
    public function getFormationCategories(): Collection
    {
        return $this->formationCategories;
    }

    public function addFormationCategory(FormationCategory $formationCategory): static
    {
        if (!$this->formationCategories->contains($formationCategory)) {
            $this->formationCategories->add($formationCategory);
            $formationCategory->setSection($this);
        }

        return $this;
    }

    public function removeFormationCategory(FormationCategory $formationCategory): static
    {
        if ($this->formationCategories->removeElement($formationCategory)) {
            // set the owning side to null (unless already changed)
            if ($formationCategory->getSection() === $this) {
                $formationCategory->setSection(null);
            }
        }

        return $this;
    }
}
