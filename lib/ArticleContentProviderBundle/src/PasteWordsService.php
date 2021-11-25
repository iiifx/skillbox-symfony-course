<?php

declare(strict_types=1);

namespace SkillboxSymfony\ArticleContentProviderBundle;

class PasteWordsService
{
    public function paste(string $text, string $word, int $wordsCount = 1): string
    {
        $parts = explode(' ', $text);

        do {
            $position = random_int(0, count($parts) - 1);

            $begin = array_slice($parts, 0, $position);
            $end = array_slice($parts, $position, count($parts) - 1);

            $parts = array_merge($begin, [$word], $end);
        } while (--$wordsCount);

        return implode(' ', $parts);
    }
}
