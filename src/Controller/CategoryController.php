<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoriesType;
use App\Repository\categoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("/categories/list", name="category_list")
     */
    public function categoryList(categoryRepository $categoryRepository)
    {

        $category = $categoryRepository->findAll();

        // je retourne la vue avec Twig qui compile la page en HTML
        return $this->render('categories.html.twig', [

            // je fais le lien avec mon fichier Twig
            'categories' => $category

        ]);
    }

    /**
     * je créé une url avec une wildcard "id"
     * qui contiendra l'id d'une categorie
     * @Route("/category/show/{id}", name="category_show")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe categoryRepository dans une variable $categoryRepository
     * (autowire)
     */


    public function categorieshow($id, CategoryRepository $categoryRepository)
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

    /**
     * @Route("admin/category/insert-form", name="admin_category_form")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */


    public function insertStaticArticle(Request $request, EntityManagerInterface $entityManager)
    {
        //

        $category = new Category();

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // pour pouvoir définir les valeurs de ses propriétés
        //(et donc créer un nouvel enregistrement dans la table article en BDD)
        $form=$this->createForm(CategoriesType::class, $category);

        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité (un peu comme un commit
        // dans Git)

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('admin_category_list');
        }

        $formView = $form->createView();
        // j'affiche le rendu d'un fichier twig
        return $this->render('caterory/admin/insert_form.html.twig', [
            'formView' => $formView
        ]);

    }


}
