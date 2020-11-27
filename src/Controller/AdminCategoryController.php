<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoriesType;
use App\Repository\articleRepository;
use App\Repository\categoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
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


    public function insertCategory(Request $request, EntityManagerInterface $entityManager)
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
        return $this->render('admin/caterory/insert_form.html.twig', [
            'formView' => $formView
        ]);

    }

    /**
     *
     * JE CREER UNE METHODE POUR METTRE A JOUR UN ARTICLE
     *
     * @Route("/admin/category/update/{id}", name="admin_category_update")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */

    // autowire
    public function updateCategory($id, categoryRepository $categoryRepository, EntityManagerInterface $entityManager, Request $request)

    {

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // je cible la modification dans ma page update_ via l'ID
        // ce la selectionne l'id de la base de donnée (SELECT ...FROM ...WHERE id)


        $article = $categoryRepository->find($id);


        // je retourne la modification du titre de mon article
        if (is_null($article)) {
            return $this->redirectToRoute('admin_category_list');
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

            return $this->redirectToRoute('admin_category_list');
        }

        $formView = $form->createView();

        // j'affiche le rendu d'un fichier twig
        return $this->render('categories/admin/update_form.html.twig', [
            'formView' => $formView
        ]);

    }

    /**
     *
     * JE CREER UNE METHODE POUR SUPPRIMER UN ARTICLE
     *
     * @Route("/admin/category_delete/{id}", name="admin_category_delete")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */


    public function deleteCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // je cible la modification dans ma page update_ via l'ID
        // ce la selectionne l'id de la base de donnée (SELECT ...FROM ...WHERE id)

        $article = $categoryRepository->find($id);

        // je supprime un article


        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité
        // un peu comme un commit dans Git)


        // si mon article n'est pas NULL alors je demande à supprimer l'article

        if (!is_null($category)){
            $entityManager->remove($category);
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

        return $this->redirectToRoute('admin_category_list');
    }


}
