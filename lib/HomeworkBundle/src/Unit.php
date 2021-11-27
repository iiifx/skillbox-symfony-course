<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle;

class Unit
{
    public function __construct(
        protected string $name,
        protected int $cost,
        protected int $strength,
        protected int $health
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function getHealth(): int
    {
        return $this->health;
    }
}
