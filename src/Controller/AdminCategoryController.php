<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoriesType;
use App\Repository\categoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{

    /**
     * @Route("/admin/category/list", name="admin_category_list")
     */
    public function categoryList(categoryRepository $categoryRepository)
    {

        $category = $categoryRepository->findAll();

        // je retourne la vue avec Twig qui compile la page en HTML
        return $this->render('categories/admin/categories.html.twig', [

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
     * @Route("admin/category/insert-form", name="admin_category_insert")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe CategoryRepository dans une variable $CategoryRepository
     * (autowire)
     */


    public function insertCategory(Request $request, EntityManagerInterface $entityManager)
    {
        //

        $category = new Category();

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // pour pouvoir définir les valeurs de ses propriétés
        //(et donc créer un nouvel enregistrement dans la table catégorie en BDD)
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
        return $this->render('categories/admin/insert_form.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     *
     * JE CREER UNE METHODE POUR METTRE A JOUR UNE CATEGORIE
     *
     * @Route("/admin/category/update/{id}", name="admin_category_update")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe CategoryRepository dans une variable $CategoryRepository
     * (autowire)
     */

    // autowire
    public function updateCategory($id, categoryRepository $categoryRepository, EntityManagerInterface $entityManager, Request $request)

    {

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // je cible la modification dans ma page update_ via l'ID
        // ce la selectionne l'id de la base de donnée (SELECT ...FROM ...WHERE id)


        $category = $categoryRepository->find($id);


        // je retourne la modification du titre de ma categorie
        if (is_null($category)) {
            return $this->redirectToRoute('admin_category_list');
        }

        $form = $this->createForm(categoriesType::class, $category);

        $form->handleRequest($request);



        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité
        // un peu comme un commit dans Git)
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash(
                "success",
                "La catégorie a été modifié !"
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
     * JE CREER UNE METHODE POUR SUPPRIMER UNE CATEGORIE
     *
     * @Route("/admin/category_delete/{id}", name="admin_category_delete")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe Categoryepository dans une variable $categoryRepository
     * (autowire)
     */


    public function deleteCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {

        // j'instancie la classe d'entité (un obbjet constituant un exemplaire de la classe) Article

        // je cible la modification dans ma page update_ via l'ID
        // ce la selectionne l'id de la base de donnée (SELECT ...FROM ...WHERE id)

        $category = $categoryRepository->find($id);



        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité
        // un peu comme un commit dans Git)


        // si ma catégorie n'est pas NULL alors je demande à supprimer la catégorie

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
        // je fais une redirection vers la page liste des categories

        return $this->redirectToRoute('admin_category_list');
    }


}
