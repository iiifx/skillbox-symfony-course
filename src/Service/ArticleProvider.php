<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Article;

class ArticleProvider
{
    public function getArticle(): Article
    {
        return $this->getArticles()[mt_rand(0, 4)];
    }

    /**
     * @return Article[]
     */
    public function getArticles(): array
    {
        return [
            Article::create('new-article-1', 'Некая статья 1', '/images/cat-food.jpg'),
            Article::create('new-article-2', 'Некая статья 2', '/images/cat-banner.jpg'),
            Article::create('new-article-3', 'Некая статья 3', '/images/cat-banner1.jpg'),
            Article::create('new-article-4', 'Некая статья 4', '/images/cat-food.jpg'),
            Article::create('new-article-5', 'Некая статья 5', '/images/cat-banner.jpg'),
        ];
    }
}
