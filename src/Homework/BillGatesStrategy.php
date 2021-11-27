<?php

declare(strict_types=1);

namespace App\Homework;

use SymfonySkillbox\HomeworkBundle\StrategyInterface;
use SymfonySkillbox\HomeworkBundle\Unit;

class BillGatesStrategy implements StrategyInterface
{
    /**
     * @param Unit[] $units
     */
    public function next(array $units, int $resource): ?Unit
    {
        // Сортируем юниты по стоимости, в порядке убывания
        usort($units, static fn(Unit $a, Unit $b) => $b->getCost() <=> $a->getCost());

        // Используем самый дорогой юнит из доступных по стоимости
        foreach ($units as $unit) {
            if ($unit->getCost() <= $resource) {
                return $unit;
            }
        }

        return null;
    }
}
