<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle;

class StrengthStrategy implements StrategyInterface
{
    /**
     * @param Unit[] $units
     */
    public function next(array $units, int $resource): ?Unit
    {
        // Сортируем юниты по силе, в порядке убывания
        usort($units, static fn(Unit $a, Unit $b) => $b->getStrength() <=> $a->getStrength());

        // Используем самый сильный юнит из доступных по стоимости
        foreach ($units as $unit) {
            if ($unit->getCost() <= $resource) {
                return $unit;
            }
        }

        return null;
    }
}
