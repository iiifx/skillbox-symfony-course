<?php

namespace App\Twig;

use App\Service\MarkdownParser;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    protected MarkdownParser $markdown;

    public function __construct(MarkdownParser $markdown)
    {
        $this->markdown = $markdown;
    }

    public function parseMarkdown($content): string
    {
        return $this->markdown->parse($content);
    }
}
