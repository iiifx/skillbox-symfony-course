<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Название статьи',
                'help' => 'Не используйте слово "собака"',
            ])
            ->add('body')
            ->add('publishedAt', options: [
                'widget' => 'single_text',
            ]);

        $builder->get('body')->addModelTransformer(
            new CallbackTransformer(
                static fn($bodyFromDb) => str_replace('**собака**', 'собака', $bodyFromDb),
                static fn($bodyFromInput) => str_replace('собака', '**собака**', $bodyFromInput),
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
