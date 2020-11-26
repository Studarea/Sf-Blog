<?php


namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\articleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/articles/list", name="article_list")
     */
    public function articleList(articleRepository $articleRepository)
    {

        $articles = $articleRepository->findAll();


        // je retourne la vue avec Twig qui compile la page en HTML
        return $this->render('articles.html.twig', [

            // je fais le lien avec mon fichier Twig
            'articles' => $articles

        ]);
    }


    /**
     * je créé une url avec une wildcard "id"
     * qui contiendra l'id d'un article
     * @Route("/article/show/{id}", name="article_show")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */


    public function articleShow($id, ArticleRepository $articleRepository)
    {
        // j'utilise l'articleRepository avec la méthode find
        // pour faire une requête SQL SELECT en BDD
        // et retrouver l'article dont l'id correspond à l'id passé en URL
        $article = $articleRepository->find($id);

        // je retourne la vue avec Twig qui compile la page en HTML
        return $this->render('article.html.twig', [

            'article' => $article
        ]);


    }


    /**
     *
     * JE CREER UNE METHODE POUR CREER ' insérer ' UN ARTICLE
     *
     * @Route("/article/insert-form", name="article_form")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */



    // EntityManager gère les données avec Doctrine, permet le CUD (create, update, delete)
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
         }

        // je récupère le gabarit de ce formulaire
        // et je créer une vue me permettant d'afficher le formulaire dans une page html.twig.
        $formView = $form->createView();


        // j'affiche le rendu d'un fichier twig compilé en HTML
        return $this->render('insert_form.html.twig', [
            'formView' => $formView
        ]);
    }


    /**
     *
     * JE CREER UNE METHODE POUR METTRE A JOUR UN ARTICLE
     *
     * @Route("/article/update-static/{id}", name="article_update_static")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */


    public function updateStaticArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // je cible la modification dans ma page update_ via l'ID
        // ce la selectionne l'id de la base de donnée (SELECT ...FROM ...WHERE id)

        $article = $articleRepository->find($id);


        // je retourne la modification du titre de mon article

        $article->setTitle("A la piscine on fait plouf !!!");
        $article->setDateCreated(new \DateTime());
        $article->setDatePublished(new \DateTime());

        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité
        // un peu comme un commit dans Git)
        $entityManager->persist($article);
        $entityManager->flush();


        // j'affiche le rendu d'un fichier twig
        return $this->render('update_static.html.twig');
    }



    /**
     *
     * JE CREER UNE METHODE POUR SUPPRIMER UN ARTICLE
     *
     * @Route("/article/article_delete/{id}", name="article_delete")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */


    public function deleteStaticArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // je cible la modification dans ma page update_ via l'ID
        // ce la selectionne l'id de la base de donnée (SELECT ...FROM ...WHERE id)

        $article = $articleRepository->find($id);

        // je supprime un article


        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité
        // un peu comme un commit dans Git)


        // si mon article n'est pas NULL alors je demande à supprimer l'article

        if (!is_null($article)){
            $entityManager->remove($article);
            $entityManager->flush();

            // $this = fait référence à la classe actuelle
            // je cible la propriété addFlash demandant d'afficher un message après l'action delete
            // et type "succès"
            $this->addFlash(
                "success",
                "Bien joué"
            );
        }
        // je fais une redirection vers la page liste des articles

        return $this->redirectToRoute('article_list');
    }

}
