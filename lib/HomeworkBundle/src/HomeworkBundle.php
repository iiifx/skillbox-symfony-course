<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonySkillbox\HomeworkBundle\DependencyInjection\HomeworkBundleExtension;

class HomeworkBundle extends Bundle
{
    public function getContainerExtension(): HomeworkBundleExtension
    {
        return $this->extension ??= new HomeworkBundleExtension();
    }
}
