<?php

declare(strict_types=1);

namespace App\Homework;

use SymfonySkillbox\HomeworkBundle\Unit;
use SymfonySkillbox\HomeworkBundle\UnitProviderInterface;

class Warcraft3HumanUnitProvider implements UnitProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getUnits(): array
    {
        return [
            new Unit('Peasant', 75, 5, 220),
            new Unit('Footman', 135, 12, 420),
            new Unit('Rifleman', 205, 21, 535),
            new Unit('Priest', 135, 8, 290),
            new Unit('Sorceress', 155, 11, 325),
            new Unit('Knight', 245, 34, 835),
        ];
    }
}
