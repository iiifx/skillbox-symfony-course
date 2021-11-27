<?php

declare(strict_types=1);

namespace App\Homework;

use SymfonySkillbox\HomeworkBundle\StrategyInterface;
use SymfonySkillbox\HomeworkBundle\Unit;

class ZergRushStrategy implements StrategyInterface
{
    /**
     * @param Unit[] $units
     */
    public function next(array $units, int $resource): ?Unit
    {
        // Сортируем юниты по стоимости, в порядке возрастания
        usort($units, static fn(Unit $a, Unit $b) => $a->getCost() <=> $b->getCost());

        // Используем всегда самый дешевый юнит
        if (isset($units[0]) && ($units[0]->getCost() <= $resource)) {
            return $units[0];
        }

        return null;
    }
}
