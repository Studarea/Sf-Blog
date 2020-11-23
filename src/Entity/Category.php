<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;




// J'ai créé une base de données en modifiant la variable DATABASE_URL
// du fichier .env.local (que j'ai créé en copiant le fichier .env)
// puis en utilisant la ligne de commande doctrine:database:create

// J'ai créé une classe Book qui est une entité car elle possède l'annotation
// @ORM\Entity

/**
 * @ORM\Entity()
 */
class Category

{

    //Dans category : id, title, color, date de publication, date de création, est publié ? (oui / non)

    // J'ai créé autant de propriétés que de colonnes voulues dans la table
    // et j'ai mappé les propriétés avec des annotations et la classe ORM (attention
    // de ne pas oublier le use correspondant)

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
     * @ORM\Column(type="integer")
     */
    private $color;


    /**
     * @ORM\Column(type="date")
     */
    private $date_published;


    /**
     * @ORM\Column(type="date")
     */
    private $date_created;


    /**
     * @ORM\Column(type="boolean")
     */
    private $published;


}


?>