<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle;

class UnitFactory
{
    protected StrategyInterface $strategy;
    /**
     * @var UnitProviderInterface[]
     */
    protected iterable $unitProviders;

    /**
     * @param UnitProviderInterface[] $unitProviders
     */
    public function __construct(StrategyInterface $strategy, iterable $unitProviders)
    {
        $this->strategy = $strategy;
        $this->unitProviders = $unitProviders;
    }

    /**
     * Производит армию
     *
     * @return Unit[]
     */
    public function produceUnits(int $resources): array
    {
        $units = [];
        foreach ($this->unitProviders as $unitProvider) {
            foreach ($unitProvider->getUnits() as $unit) {
                $units[] = $unit;
            }
        }

        $army = [];
        while ($unit = $this->strategy->next($units, $resources)) {
            $army[] = $unit;
            $resources -= $unit->getCost();
        }

        return $army;
    }
}
