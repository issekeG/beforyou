<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'activities')]
    private ?Subsidiary $subsidiary = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @var Collection<int, Realisation>
     */
    #[ORM\OneToMany(targetEntity: Realisation::class, mappedBy: 'activity', cascade: ['persist', 'remove'])]
    private Collection $realisations;

    public function __construct()
    {
        $this->realisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSubsidiary(): ?Subsidiary
    {
        return $this->subsidiary;
    }

    public function setSubsidiary(?Subsidiary $subsidiary): static
    {
        $this->subsidiary = $subsidiary;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? 'Activité sans nom';
    }

    /**
     * @return Collection<int, Realisation>
     */
    public function getRealisations(): Collection
    {
        return $this->realisations;
    }

    public function addRealisation(Realisation $realisation): static
    {
        if (!$this->realisations->contains($realisation)) {
            $this->realisations->add($realisation);
            $realisation->setActivity($this);
        }

        return $this;
    }

    public function removeRealisation(Realisation $realisation): static
    {
        if ($this->realisations->removeElement($realisation)) {
            // set the owning side to null (unless already changed)
            if ($realisation->getActivity() === $this) {
                $realisation->setActivity(null);
            }
        }

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlug(): void
    {
        if ($this->name && !$this->slug) {
            $slugify = new Slugify();
            $this->slug =  $slugify->slugify( $this->name);
        }
    }
}
