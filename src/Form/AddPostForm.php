<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Post;
use App\Entity\User;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPostForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Contenu',
            ])
            ->add('pathPicPost', FileType::class, [
                'mapped' => false,
                'label' => 'Image',
            ])
            ->add('LinkSocials', TextType::class, [
                'label' => 'Lien sociale',
            ] )
            ->add('BodyCenter', TextareaType::class,[
                'label' => 'Contenu Centre',
            ])
            ->add('TitleCenter', TextType::class, [
                'label' => 'Titre Centre',
            ])

            ->add('genres', CheckboxType::class, [
                'choice_label' => 'type',

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary mt-3',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
