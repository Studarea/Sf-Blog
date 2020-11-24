<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


// L'annotation Entity spécifie que la classe est considérée en tant qu'entité.
// L'attribut le plus important est repositoryClass, qui permet de spécifier un repository spécifique pour l'entité
// L'annotation Id identifie la clé primaire de la table.

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
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


}


?>