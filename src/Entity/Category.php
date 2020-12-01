<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


// L'annotation Entity spécifie que la classe est considérée en tant qu'entité.
// L'attribut le plus important est repositoryClass, qui permet de spécifier un repository spécifique pour l'entité
// L'annotation Id identifie la clé primaire de la table.

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */

class Category

{

    //Dans category : id, title, color, date de publication, date de création, est publié ? (oui / non)

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
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;


    /**
     * @ORM\Column(type="string")
     */
    private $color;


    /**
     * @ORM\Column(type="date")
     */
    private $datePublished;


    /**
     * @ORM\Column(type="date")
     */
    private $dateCreated;


    /**
     * @ORM\Column(type="boolean")
     */
    private $published;




    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="category")
     *
     *
     * La propriété articles représente la relation inverse du ManyToOne
     * C'est donc un OneToMany. Il cible l'entité Article.
     * Le mappedBy représente la propriété dans l'entité Article qui cible l'entité Category.
     *
     */
    private $articles;



    /**
     * Dans la méthode constructor (qui est appelée automatiquement),
     * à chaque fois que la classe est instanciée (donc avec le mot clé "new")
     * je déclare que la propriété articles est un array (un ArrayCollection plus exactement,
     * qui est un d'array virtuel "avec des supers pouvoirs")
     */

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }



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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getDatePublished(): ?\DateTimeInterface
    {
        return $this->datePublished;
    }

    public function setDatePublished(\DateTimeInterface $datePublished): self
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
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
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }



    /**
     * La méthode addArticle permet d'ajouter un article dans une catégorie, sans écraser les autres articles.
     * Vu que la propriété articles est un tableau, on peut avoir plusieurs articles
     */

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    /**
     * La méthode removeArticle permet supprimer un article de la rubrique catégorie,
     * sans supprimer les autres articles
     */

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }


}


?>