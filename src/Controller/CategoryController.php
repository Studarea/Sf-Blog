<?php


namespace App\Controller;

use App\Entity\Category;
use App\Repository\categoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("/categorys/list", name="category_list")
     */
    public function categoryList(categoryRepository $categoryRepository)
    {

        $category = $categoryRepository->findAll();

        // je retourne la vue avec Twig qui compile la page en HTML
        return $this->render('categorys.html.twig', [

            // je fais le lien avec mon fichier Twig
            'categorys' => $category

        ]);
    }

    /**
     * je créé une url avec une wildcard "id"
     * qui contiendra l'id d'une categorie
     * @Route("/category/{id}", name="category_show")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe categoryRepository dans une variable $categoryRepository
     * (autowire)
     */


    public function categoryShow($id, CategoryRepository $categoryRepository)
    {
        // j'utilise categoryRepository avec la méthode find
        // pour faire une requête SQL SELECT en BDD
        // et retrouver la category dont l'id correspond à l'id passé en URL
        $category = $categoryRepository->find($id);

        // je retourne la vue avec Twig qui compile la page en HTML
        return $this->render('category.html.twig', [

            'category' => $category
        ]);

    }
}
