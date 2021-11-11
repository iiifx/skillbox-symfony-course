<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method User|null getUser()
 */
class ArticlesController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected ArticleRepository $articleRepository,
        protected PaginatorInterface $paginator
    ) {
    }

    #[Route('/admin/articles', name: 'app_admin_articles')]
    #[IsGranted('ROLE_ADMIN_ARTICLE')]
    public function index(Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $this->articleRepository->orderLatest(),
            $request->query->getInt('page', 1),
            $request->query->get('perPage', 20)
        );

        return $this->render('admin/articles/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/admin/articles/create', name: 'app_admin_article_create')]
    #[IsGranted('ROLE_ADMIN_ARTICLE')]
    public function create(Request $request)
    {
        $form = $this->createForm(ArticleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            if (!$article instanceof Article) {
                throw new LogicException();
            }

            $article->setPublishedAt(new DateTimeImmutable());
            $article->setDescription('...');

            $this->em->persist($article);
            $this->em->flush();

            $this->addFlash('flash_message', 'Успешно создано');

            return $this->redirectToRoute('app_admin_articles');
        }

        return $this->render('admin/articles/create.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/articles/{id}/edit', name: 'app_admin_article_edit')]
    #[IsGranted('MANAGE', subject: 'article')]
    public function edit(Article $article)
    {
        return new Response('...');
    }
}
