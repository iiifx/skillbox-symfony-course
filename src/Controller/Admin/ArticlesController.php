<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Service\FileUploader;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        protected PaginatorInterface $paginator,
        protected FileUploader $articleFileUploader,
    ) {
    }

    #[Route('/admin/articles', name: 'app_admin_articles')]
    #[IsGranted('ROLE_ADMIN_ARTICLE')]
    public function index(Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $this->articleRepository->findAllWithSearchQuery(
                $request->query->get('q'),
                true
            ),
            $request->query->getInt('page', 1),
            $request->query->get('perPage', 20)
        );

        return $this->render('admin/articles/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/admin/articles/create', name: 'app_admin_article_create')]
    #[IsGranted('ROLE_ADMIN_ARTICLE')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(ArticleFormType::class);

        if ($this->handleFormRequest($form, $request)) {
            $this->addFlash('flash_message', 'Успешно создано');

            return $this->redirectToRoute('app_admin_articles');
        }

        return $this->render('admin/articles/create.html.twig', [
            'articleForm' => $form->createView(),
            'showError' => $form->isSubmitted(),
        ]);
    }

    #[Route('/admin/articles/{id}/edit', name: 'app_admin_article_edit')]
    #[IsGranted('MANAGE', subject: 'article')]
    public function edit(Article $article, Request $request): Response
    {
        $form = $this->createForm(ArticleFormType::class, $article, [
            'enabled_published_at' => true,
        ]);

        if ($this->handleFormRequest($form, $request)) {
            $this->addFlash('flash_message', 'Успешно изменено');

            return $this->redirectToRoute('app_admin_article_edit', [
                'id' => $article->getId()
            ]);
        }

        return $this->render('admin/articles/edit.html.twig', [
            'articleForm' => $form->createView(),
            'showError' => $form->isSubmitted(),
        ]);
    }

    private function handleFormRequest(FormInterface $form, Request $request): ?Article
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            if (!$article instanceof Article) {
                throw new LogicException();
            }
            if (!$article->getPublishedAt()) {
                $article->setPublishedAt(new DateTimeImmutable());
            }

            /** @var UploadedFile|null $uploadedFile */
            if ($uploadedFile = $form->get('image')->getData()) {
                $this->articleFileUploader->removeFile($article->getImageFilename());
                $filename = $this->articleFileUploader->uploadFile($uploadedFile);
                $article->setImageFilename($filename);
            }

            $this->em->persist($article);
            $this->em->flush();

            return $article;
        }

        return null;
    }
}
