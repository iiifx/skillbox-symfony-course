<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle;

interface StrategyInterface
{
    /**
     * @param Unit[] $units
     */
    public function next(array $units, int $resource): ?Unit;
}
