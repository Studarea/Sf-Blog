<?php


namespace App\Controller;

use App\Repository\articleRepository;
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


        return $this->render('articles.html.twig', [

            // ici je fait le lien avec la variable à mon fichier html.twig'
            'articles' => $articles

        ]);

    }



    /**
     * je créé une url avec une wildcard "id"
     * qui contiendra l'id d'un article
     * @Route("/article/{id}", name="article_show")
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

        return $this->render('article.html.twig', [

            'article' => $article
        ]);


    }






}
