<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset_uploads', [AppAssetUploads::class, 'assetUploads']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('markdown_cached', [AppRuntime::class, 'parseMarkdown'], ['is_safe' => ['html']]),
        ];
    }
}
