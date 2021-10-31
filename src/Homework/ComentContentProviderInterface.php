<?php

declare(strict_types=1);

namespace App\Homework;

interface ComentContentProviderInterface
{
    public function get(string $word = null, int $wordsCount = 0): string;
}
