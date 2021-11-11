<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Homework\ArticleWordsFilter;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function __construct(
        protected UserRepository $userRepository,
        protected ArticleWordsFilter $articleWordsFilter
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Название статьи',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Описание статьи',
                'attr' => ['rows' => 3],
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Содержимое статьи',
                'attr' => ['rows' => 10],
            ])
            ->add('publishedAt', options: [
                'widget' => 'single_text',
                'label' => 'Дата публикации статьи',
            ])
            ->add('keywords', options: [
                'label' => 'Ключевые слова статьи',
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => static fn(User $user) => sprintf('#%d %s', $user->getId(), $user->getFirstName()),
                'placeholder' => 'Выберите автора статьи',
                'choices' => $this->userRepository->findAllSorted(),
            ]);

        $transformer = new CallbackTransformer(
            fn($fromDb) => $fromDb,
            fn($fromInput) => $this->articleWordsFilter->filter($fromInput, ['стакан']),
        );
        $builder->get('description')->addModelTransformer($transformer);
        $builder->get('body')->addModelTransformer($transformer);

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
        ]);
    }
}
