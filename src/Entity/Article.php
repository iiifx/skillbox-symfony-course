<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title = null;
    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private ?string $slug = null;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $body = null;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $publishedAt = null;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $author = null;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $likeCount = null;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $imageFilename = null;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private ?string $description = null;
    /**
     * @ORM\Column(type="array")
     */
    private array $keywords = [];
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime_immutable")
     */
    private ?DateTimeImmutable $createdAt = null;
    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getPublishedAt(): ?DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getLikeCount(): ?int
    {
        return $this->likeCount;
    }

    public function setLikeCount(?int $likeCount): self
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    public function getImagePath(): string
    {
        return sprintf('images/%s', $this->getImageFilename());
    }

    public function getAuthorAvatarPath(): string
    {
        return sprintf(
            'https://robohash.org/%s.png?set=set4',
            str_replace(' ', '-', $this->getAuthor())
        );
    }

    public function addLike(int $count = 1): static
    {
        $this->likeCount += $count;

        return $this;
    }

    public function removeLike(int $count = 1): static
    {
        $this->likeCount -= $count;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    public function setKeywords(array $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
