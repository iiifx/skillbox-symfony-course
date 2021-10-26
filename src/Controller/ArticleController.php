<?php

namespace App\Controller;

use App\Entity\Article;
use App\Homework\ArticleContentProviderInterface;
use App\Service\ArticleProvider;
use App\Service\SlackService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleProvider $articles)
    {
        //dd($this->getParameter('secret_value'));

        return $this->render('articles/homepage.html.twig', [
            'articles' => $articles->getArticles(),
        ]);
    }

    ///**
    // * @Route("/articles/article_content", name="app_article_content")
    // */
    //public function content(Request $request, ArticleContentProviderInterface $provider)
    //{
    //    $content = '';
    //    if ($paragraphs = (int)$request->query->get('paragraphs')) {
    //        $content = $provider->get(
    //            $paragraphs,
    //            $request->query->get('word'),
    //            (int)$request->query->get('wordCount')
    //        );
    //    }
    //
    //    return $this->render('articles/article_content.html.twig', [
    //        'content' => $content,
    //    ]);
    //}

    /**
     * @Route("/articles/{slug}", name="app_article_show")
     */
    public function show(
        string $slug,
        ArticleProvider $articles,
        SlackService $slack,
        ArticleContentProviderInterface $provider,
        EntityManagerInterface $em
    ) {
        //$slack->sendMessage('This is an amazing message!');

        //$article = $articles->getArticle();
        //$content = $parser->parse($article->getContent());

        $repository = $em->getRepository(Article::class);
        $article = $repository->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw $this->createNotFoundException(sprintf('Article %s not found', $slug));
        }

        //# Список возможных слов и их частота
        //$wordList = [
        //    ['ONE', 5],
        //    ['TWO', 10],
        //    ['THREE', 15],
        //    ['FOUR', 20],
        //    ['FIVE', 25],
        //];
        //
        //# С вероятностью в 70% используем одно из списка
        //$wordData = [null, 0];
        //if (random_int(1, 100) <= 70) {
        //    $wordData = $wordList[random_int(0, 4)];
        //}
        //
        //# Генерируем текст с 2-10 параграфов включая полученное слово
        //$content = $provider->get(random_int(2, 10), ...$wordData);
        ////$content = $parser->parse($content);

        $comments = [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
        ];

        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'comments' => $comments,
        ]);
    }

    ///**
    // * @Route("/api/v1/article_content", name="app_api", methods={"POST"})
    // */
    //public function api(Request $request, ArticleContentProviderInterface $provider)
    //{
    //    $params = $request->toArray();
    //
    //    $paragraphs = (int)($params['paragraphs'] ?? 1);
    //    $word = $params['word'] ?? null;
    //    $wordCount = (int)($params['wordCount'] ?? 0);
    //
    //    $content = $provider->get($paragraphs, $word, $wordCount);
    //
    //    return $this->json([
    //        'text' => $content,
    //    ]);
    //}
}
