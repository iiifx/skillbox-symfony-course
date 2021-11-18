<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Homework\ArticleWordsFilter;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ArticleFormType extends AbstractType
{
    private array $options;

    public function __construct(
        protected UserRepository $userRepository,
        protected ArticleWordsFilter $articleWordsFilter
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->options = $options;

        $builder
            ->add('image', FileType::class, [
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Выберите изображение'
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'Название статьи',
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Длина названия должна быть больше 3 знаков'
                    ]),
                    new Regex([
                        'pattern' => '/\d+/',
                        'match' => false,
                        'message' => 'Нельзя создать статью, название которой содержит цифру',
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Описание статьи',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Необходимо заполнить описание'
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Длина описания не должна превышать 100 знаков'
                    ])
                ]
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Содержимое статьи',
                'rows' => 10,
                'required' => true,
            ])
            ->add('keywords', options: [
                'label' => 'Ключевые слова статьи',
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => static fn(User $user) => sprintf('#%d %s', $user->getId(), $user->getFirstName()),
                'placeholder' => 'Выберите автора статьи',
                'choices' => $this->userRepository->findAllSorted(),
                'required' => true,
                'disabled' => !$this->canEditArticle(),
            ]);

        if ($options['enabled_published_at']) {
            $builder
                ->add('publishedAt', options: [
                    'widget' => 'single_text',
                    'label' => 'Дата публикации статьи',
                ]);
        }

        //$transformer = new CallbackTransformer(
        //    fn($fromDb) => $fromDb,
        //    fn($fromInput) => $this->articleWordsFilter->filter((string)$fromInput, ['стакан']),
        //);
        //$builder->get('description')->addModelTransformer($transformer);
        //$builder->get('body')->addModelTransformer($transformer);

        //$builder->get('body')->addModelTransformer(
        //    new CallbackTransformer(
        //        fn($bodyFromDb) => str_replace('**собака**', 'собака', $bodyFromDb),
        //        fn($bodyFromInput) => str_replace('собака', '**собака**', $bodyFromInput),
        //    )
        //);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'enabled_published_at' => false,
        ]);
    }

    private function getArticle(): ?Article
    {
        return $this->options['data'] ?? null;
    }

    private function canEditArticle(): bool
    {
        $article = $this->getArticle();

        return !($article?->getId() && $article?->isPublished());
    }
}
