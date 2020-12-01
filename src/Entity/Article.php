<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

// un alias Assert qui utilise la classe Constraints
use Symfony\Component\Validator\Constraints as Assert;


// Dans article : id, title, content, image, date de publication, date de création, est publié ? (oui / non)


// L'annotation Entity spécifie que la classe est considérée en tant qu'entité.
// L'attribut le plus important est repositoryClass, qui permet de spécifier un repository spécifique pour l'entité
// L'annotation Id identifie la clé primaire de la table.


/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */

class Article

{

// Dans article : id, title, content, image, date de publication, date de création, est publié ? (oui / non)

    // J'ai créé autant de propriétés que de colonnes voulues dans la table
    // et j'ai mappé les propriétés avec des annotations et la classe ORM
    // (attention de ne pas oublier le use correspondant)

    // je créer la clé primaire ID
    // j'autoincrémente la valeur de l'ID
    // je créer une colonne de type intéger

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */

    /* propriété de la table ci-dessus */
    private $id;



    /**
    * @ORM\Column(type="string", length=255)
    *
     *
     * NotBlank() est une contrainte pour vérifier qu'une valeur n'est pas égale à null :
    * @Assert\NotBlank(
    *     message="le champs titre est vide"
    * )
    *
    * @Assert\Length(
    *     min= 4,
    *     max= 50,
    *     minMessage="Il n'y a pas assez de lettres",
    *     maxMessage="Il n'y a trop de lettres !"
    * )
    */

    /* propriété de la table ci-dessus */
    private $title;


    /**
     * @ORM\Column(type="text")
     *
     *
     * NotBlank() : Pour vérifier qu'une valeur n'est pas égale à null :
     * @Assert\NotBlank(
     *     message="Merci de remplir le titre !"
     * )
     *
     * @Assert\Length(
     *     min= 20,
     *     max= 1000,
     *     minMessage="Il n'y a pas assez de lettres",
     *     maxMessage="Il n'y a trop de lettres !"
     * )
     */

    private $content;





    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotBlank (
     *     message="le champs date est vide"
     * )
     *
     */
    private $datePublished;


    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotBlank (
     *     message="le champs date est vide"
     * )
     *
     */
    private $dateCreated;



    /**
     * @ORM\Column(type="boolean")
     *
     *
     */
    private $published;



    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageFileName;


    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     *
     * * La propriété category représente la relation inverse du OneToMany
     *  C'est donc un ManyToOne. Il cible l'entité Category.
     *  Le targetEntity représente la propriété dans l'entité Category qui cible l'entité Article.
     *
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }



    public function getDatePublished(): ?\DateTimeInterface
    {
        return $this->datePublished;
    }

    public function setDatePublished($datePublished): self
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }



    /**
     * La méthode getCategory permet de récupérer une catégorie pour un article
     */

    public function getCategory(): ?category
    {
        return $this->category;
    }


    /**
     * La méthode setCategory permet de "modifier" une catégorie pour un article
     */

    public function setCategory(?category $category): self
    {
        $this->category = $category;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getImageFileName()
    {
        return $this->imageFileName;
    }

    /**
     * @param mixed $imageFileName
     */
    public function setImageFileName($imageFileName): void
    {
        $this->imageFileName = $imageFileName;
    }



}


?>