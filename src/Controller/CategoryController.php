<?php


namespace App\Controller;

use App\Entity\Category;
use App\Repository\categoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/category/show/{id}", name="category_show")
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

    /**
     * @Route("/category/insert-static", name="category_insert_static")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */


    public function insertStaticArticle(EntityManagerInterface $entityManager)
    {
        //

        $category = new Category();

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // pour pouvoir définir les valeurs de ses propriétés
        //(et donc créer un nouvel enregistrement dans la table article en BDD)

        $category->setTitle("Titre de ma catégorie");
        $category->setDateCreated(new \DateTime());
        $category->setDatePublished(new \DateTime());
        $category->setColor("yellow");
        $category->setPublished(true);

        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité (un peu comme un commit
        // dans Git)
        $entityManager->persist($category);

        // j'utilise la méthode flush de l'EntityManager pour insérer en BDD toutes les entités
        // "pré-sauvegardées" (persistées)
        $entityManager->flush();


        // j'affiche le rendu d'un fichier twig
        return $this->render('insert_static.html.twig');

    }


}
