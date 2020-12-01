<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            // dans mon gabarit de formulaire, je créé "l'input" category
            // relié à ma propriété category dans l'entité Article
            // Vu que c'est une relation vers une autre entité (une autre table)
            // je lui passe en type "EntityType"

            ->add('title')
            ->add('content')
            ->add('image')
            ->add('datePublished', DateType::class, [
                 'widget' => 'single_text'
            ])
            ->add('dateCreated', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('published')
            ->add('category', EntityType::class, [
                'class'=>Category::class,
                // dans l'entité catégorie je cible le title
                // dans la liste déroulante je choisi la propriété à afficher
                'choice_label' => 'title'
            ])

            ->add('Envoyer', SubmitType::class)
        ;
    }


    // mettre ici le commentaire

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);


    }
}
