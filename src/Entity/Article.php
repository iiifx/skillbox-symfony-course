<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use App\Trait\Entity\TimestampableEntity;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $slug;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $publishedAt;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $likeCount;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFilename;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $description;
    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="article", fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"createdAt"= "DESC"})
     */
    private $comments;
    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="articles", fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"createdAt"= "DESC"})
     */
    private $tags;
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

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

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getNonDeletedComments(): Collection
    {
        //$criteria = Criteria::create()
        //    ->andWhere(Criteria::expr()?->isNull('deletedAt'))
        //    ->orderBy(['createdAt', 'DESC']);
        //
        //return $this->comments->matching($criteria);

        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
