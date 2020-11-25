<?php


namespace App\Controller;

use App\Entity\Article;
use App\Repository\articleRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/article/insert-static", name="article_insert_static")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */


    public function insertStaticArticle(EntityManagerInterface $entityManager)
    {

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // pour pouvoir définir les valeurs de ses propriétés
        //(et donc créer un nouvel enregistrement dans la table article en BDD)

        $article = new Article();

        // Je définis les valeurs des propriétés de l'entité Article
        // qui seront les valeurs des colonnes correspondantes en BDD

        $article->setTitle("Titre de mon article");
        $article->setContent("Titre de mon article");
        $article->setImage("https://i-df.unimedias.fr/2017/06/07/piscine_katrinaelena.jpg?auto=format%2Ccompress&crop=faces&cs=tinysrgb&fit=crop&h=590&w=1050");
        $article->setDateCreated(new \DateTime());
        $article->setDatePublished(new \DateTime());
        $article->setPublished(true);

        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité
        //(un peu comme un commit dans Git)
        $entityManager->persist($article);

        // j'utilise la méthode flush de l'EntityManager pour insérer en BDD toutes les entités
        // "pré-sauvegardées" (persistées)
        $entityManager->flush();


        // j'affiche le rendu d'un fichier twig
        return $this->render('insert_static.html.twig');

    }


    /**
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

        $article = $articleRepository->find($id);


        // je retourne la modification du titre de mon article

        $article->setTitle("A la piscine on fait plouf !!!");

        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité
        // un peu comme un commit dans Git)
        $entityManager->persist($article);
        $entityManager->flush();


        // j'affiche le rendu d'un fichier twig
        return $this->render('update_static.html.twig');
    }

}
