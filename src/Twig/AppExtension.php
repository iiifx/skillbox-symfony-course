<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('markdown_cached', [AppRuntime::class, 'parseMarkdown'], ['is_safe' => ['html']]),
        ];
    }
}
