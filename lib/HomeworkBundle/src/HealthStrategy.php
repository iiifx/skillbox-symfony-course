<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle;

class HealthStrategy implements StrategyInterface
{
    /**
     * @param Unit[] $units
     */
    public function next(array $units, int $resource): ?Unit
    {
        // Сортируем юниты по здоровью, в порядке убывания
        usort($units, static fn(Unit $a, Unit $b) => $b->getHealth() <=> $a->getHealth());

        // Используем юнит с самым большим здоровьем из доступных по стоимости
        foreach ($units as $unit) {
            if ($unit->getCost() <= $resource) {
                return $unit;
            }
        }

        return null;
    }
}
