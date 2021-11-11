<?php

declare(strict_types=1);

namespace App\Homework;

class ArticleWordsFilter
{
    public function filter(string $string, array $words = []): string
    {
        if (empty($words) || $string === '') {
            return $string;
        }

        $parts = explode(' ', $string);
        foreach ($words as $word) {
            foreach ($parts as $i => $part) {
                if (stripos($part, $word) !== false) {
                    // Найдено вхождение
                    unset($parts[$i]);
                }
            }
        }

        return implode(' ', $parts);
    }
}
