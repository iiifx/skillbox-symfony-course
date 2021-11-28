<?php

declare(strict_types=1);

namespace App\Homework;

use SymfonySkillbox\HomeworkBundle\Unit;
use SymfonySkillbox\HomeworkBundle\UnitProviderInterface;

class PetUnitProvider implements UnitProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getUnits(): array
    {
        return [
            new Unit('Хомяк', 1, 1, 10),
            new Unit('Кот', 10, 5, 50),
            new Unit('Пёс', 25, 8, 70),
        ];
    }
}
