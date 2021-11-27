<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle;

interface UnitProviderInterface
{
    /**
     * @return Unit[]
     */
    public function getUnits(): array;
}
