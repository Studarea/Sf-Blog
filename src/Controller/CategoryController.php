<?php


namespace App\Controller;

use App\Repository\categoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("/category/list", name="category_list")
     */
    public function articleList(categoryRepository $categoryRepository)
    {

        $category = $categoryRepository->findAll();


        return $this->render('category.html.twig', [

            // ici je fait le lien avec la variable à mon fichier html.twig'
            'category' => $category

        ]);
    }
}
