<?php


namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\articleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{

    /**
     * @Route("/admin/articles/list", name="admin_article_list")
     */
    public function articleList(articleRepository $articleRepository)
    {

        $articles = $articleRepository->findAll();


        // je retourne la vue avec Twig qui compile la page en HTML
        return $this->render('articles/admin/articles.html.twig', [

            // je fais le lien avec mon fichier Twig
            'articles' => $articles
        ]);
    }



    /**
     *
     * JE CREER UNE METHODE POUR CREER ' insérer ' UN ARTICLE
     *
     * @Route("/admin/article/insert-form", name="admin_article_form")
     *
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */


    // EntityManager gère les données avec Doctrine, permet le CUD (create, update, delete)
    // Entity Manager fait donc le lien entre les "Entités" (simples objets PHP), et la base de données :
    public function insertStaticArticle(Request $request, EntityManagerInterface $entityManager)
    {


        $article = new Article ();

        // je veux afficher un formulaire pour créer des articles
        // je créer le gabarit d'un formulaire via les lignes de commande :
        // bin/console make:form
        // ArticleType (nom du gabarit)
        // Article (nom de l’entité)

        // à présent je récupère le gabarit de formulaire ArticleType.
        // en utilisant la méthode createForm de l'AbstractController
        // (et je lui passe en paramètre le gabarit de formulaire à créer)

        // je lie mon formulaire à mon instance d'Article créé au dessus ( $article = new Article (); )
        $form=$this->createForm(ArticleType::class, $article);


        // Je viens lier le formulaire créé à la requête POST
        // de cette manière je vais pouvoir utiliser la variable $form
        // pour vérifier si les données POST ont été envoyées ou non

        // la méthode handleRequest () permet de détecter quand le formulaire a été soumis.
        // la méthode submit () connaissance des données soumises et du moment de l'envoi

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('admin_article_list');
        }

        // je récupère le gabarit de ce formulaire
        // et je créer une vue me permettant d'afficher le formulaire dans une page html.twig.
        $formView = $form->createView();


        // j'affiche le rendu d'un fichier twig compilé en HTML
        return $this->render('articles/admin/insert_form.html.twig', [
            'formView' => $formView
        ]);
    }



    /**
     *
     * JE CREER UNE METHODE POUR METTRE A JOUR UN ARTICLE
     *
     * @Route("/admin/article/update/{id}", name="admin_article_update")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */

    // autowire
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request)

    {

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // je cible la modification dans ma page update_ via l'ID
        // ce la selectionne l'id de la base de donnée (SELECT ...FROM ...WHERE id)


        $article = $articleRepository->find($id);


        // je retourne la modification du titre de mon article
        if (is_null($article)) {
            return $this->redirectToRoute('admin_article_list');
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);



        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité
        // un peu comme un commit dans Git)
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                "success",
                "L'article a été modifié !"
            );

            return $this->redirectToRoute('admin_article_list');
        }

        $formView = $form->createView();

        // j'affiche le rendu d'un fichier twig
        return $this->render('articles/admin/update_form.html.twig', [
            'formView' => $formView
        ]);

    }

    /**
     *
     * JE CREER UNE METHODE POUR SUPPRIMER UN ARTICLE
     *
     * @Route("/admin/article_delete/{id}", name="admin_article_delete")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */


    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // je cible la modification dans ma page update_ via l'ID
        // ce la selectionne l'id de la base de donnée (SELECT ...FROM ...WHERE id)

        $article = $articleRepository->find($id);



        // si mon article n'est pas NULL alors je demande à supprimer l'article

        if (!is_null($article)){
            $entityManager->remove($article);
            $entityManager->flush();

            // $this = fait référence à la classe actuelle
            // je cible la propriété addFlash demandant d'afficher un message après l'action delete
            // et type "success"
            $this->addFlash(
                "success",
                "Bien joué"
            );
        }
        // je fais une redirection vers la page liste des articles

        return $this->redirectToRoute('admin_article_list');
    }

}
