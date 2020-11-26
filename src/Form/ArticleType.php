<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // la ligne de commande bin/console make:form m'a permis de générer automatiquement ce fichier
        // c'est un gabarit de formulaire pour l'entité que j'ai spécifié en ligne de commande

        // Builder est un constructeur qui génère le formulaire
        $builder
            ->add('title')
            ->add('content')
            ->add('image')
            ->add('datePublished')
            ->add('dateCreated')
            ->add('published')
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);


    }
}
