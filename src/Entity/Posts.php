<?php

namespace App\Entity;

use App\Repository\PostsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Cocur\Slugify\Slugify;

#[ORM\Entity(repositoryClass: PostsRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Posts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 350)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'posts_image', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column]
    private ?int $readTime = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $keywords = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $seoDescription = null;

    #[ORM\Column(length: 350)]
    private ?string $seoTitle = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Tags>
     */

    #[ORM\OneToMany(targetEntity: Tags::class, mappedBy: 'post', cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $tags;

    /**
     * @var Collection<int, Sections>
     */

    #[ORM\OneToMany(targetEntity: Sections::class, mappedBy: 'posts', cascade: ["persist", "remove"])]
    private Collection $sections;

    #[ORM\Column(nullable: true)]
    private ?int $sectionNumbers = null;

    #[ORM\Column(length: 255)]
    private ?string $sector = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->sections = new ArrayCollection();
        $this->publishedAt = new \DateTimeImmutable();
    }


    public function __toString(): string
    {
        return $this->title ?? 'Post sans titre';
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

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getReadTime(): ?int
    {
        return $this->readTime;
    }

    public function setReadTime(int $readTime): static
    {
        $this->readTime = $readTime;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): static
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getSeoDescription(): ?string
    {
        return $this->seoDescription;
    }

    public function setSeoDescription(?string $seoDescription): static
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    public function getSeoTitle(): ?string
    {
        return $this->seoTitle;
    }

    public function setSeoTitle(string $seoTitle): static
    {
        $this->seoTitle = $seoTitle;

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

    /**
     * @return Collection<int, Tags>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->setPost($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getPost() === $this) {
                $tag->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sections>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Sections $section): static
    {
        if (!$this->sections->contains($section)) {
            $this->sections->add($section);
            $section->setPosts($this);
        }

        return $this;
    }

    public function removeSection(Sections $section): static
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getPosts() === $this) {
                $section->setPosts(null);
            }
        }

        return $this;
    }

    public function getSectionNumbers(): ?int
    {
        return $this->sectionNumbers;
    }

    public function setSectionNumbers(int $sectionNumbers): static
    {
        $this->sectionNumbers = $sectionNumbers;

        return $this;
    }

    public function getSector(): ?string
    {
        return $this->sector;
    }

    public function setSector(string $sector): static
    {
        $this->sector = $sector;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    public function getSectionsCount(): int
    {
        return $this->sections->count();
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
