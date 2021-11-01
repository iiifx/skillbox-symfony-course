<?php

namespace App\Trait\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait SoftDeleteableEntity
{
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    protected $deletedAt = null;

    public function setDeletedAt(DateTimeImmutable $deletedAt = null): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function isDeleted(): bool
    {
        return null !== $this->deletedAt;
    }
}
