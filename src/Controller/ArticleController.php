<?php


namespace App\Controller;

use App\Repository\articleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/article/list", name="article_list")
     */
    public function articleList(articleRepository $articleRepository)
    {

        $articles = $articleRepository->findAll();


        return $this->render('articles.html.twig', [

            // ici je fait le lien avec la variable à mon fichier html.twig'
            'articles' => $articles

        ]);



    }

}
