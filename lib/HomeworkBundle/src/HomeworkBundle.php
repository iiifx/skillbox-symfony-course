<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonySkillbox\HomeworkBundle\DependencyInjection\Compiler\UnitProviderPass;
use SymfonySkillbox\HomeworkBundle\DependencyInjection\HomeworkBundleExtension;

class HomeworkBundle extends Bundle
{
    public function getContainerExtension(): HomeworkBundleExtension
    {
        return $this->extension ??= new HomeworkBundleExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new UnitProviderPass());
    }
}
