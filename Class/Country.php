<?php

class Country
{
    public const MAXHP = 100;
    private static $compteur = 0;

    private int $id;
    private string $nom;
    private int $attaque = 0;
    private int $renforcement = 0;
    private int $bombe_nucleaire = 0;
    private int $pv = 1000;
    private ?string $image = null;


    private function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    // SETTERS / GETTERS 

    // Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getAttaque(): ?int
    {
        return $this->attaque;
    }
    public function getRenforcement(): ?int
    {
        return $this->renforcement;
    }
    public function getBombe_nucleaire(): ?int
    {
        return $this->bombe_nucleaire;
    }
    public function getPv(): ?int
    {
        return $this->pv;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    // Setters
    public function setId(int $id)
    {
        $this->id = $id;
    }
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }
    public function setAttaque(?int $attaque)
    {
        $this->attaque = $attaque;
    }
    public function setRenforcement(?int $renforcement)
    {
        $this->renforcement = $renforcement;
    }
    public function setBombe_nucleaire(?int $bombe_nucleaire)
    {
        $this->bombe_nucleaire = $bombe_nucleaire;
    }
    public function setPv(?int $pv)
    {
        $this->pv = $pv;
    }
    public function setImage(?string $image)
    {
        $this->image = $image;
    }





    // ========================================_OLD_CODE_========================================
//     public function nomPersonnage($nom)
//     {
//         $this->nom = $nom;
//         return 'Votre personnage s\'appelle ' . $this->nom;
//     }

    //     public function renforcer($soin = null)
//     {
//         if (is_null($soin)) {
//             $this->pv = 100;
//         } else {
//             $this->pv += $soin;
//             return 'Vos point de vie son de ' . $this->pv;
//         }
//     }

    //     public function tirer(Country $perso)
//     {
//         $perso->pv -= $this->attaque;
//     }

    //     public function is_alive()
//     {
//         // if ($this->hp <=0 ) {
//         //     return $this->nom .' est mort';
//         // }else {
//         //     return $this->nom.' a '.$this->hp .'PV';
//         // }
//         return $this->pv <= 0;
//     }

    //     //Constante





    //     // GETTERS

    //     public static function getCompteur()
//     {
//         return self::$compteur;
//     }

    //     public function getHp()
//     {
//         return $this->pv;
//     }
//     public function getId()
//     {
//         return $this->id;
//     }
//     public function getAtk()
//     {
//         return $this->attaque;
//     }
//     public function getNom()
//     {
//         return $this->nom;
//     }
//     public function getImg(): string
//     {
//         return $this->image ?: "https://via.placeholder.com/150";
//     }

    //     // SETTERS

    //     public function setHp($pv)
//     {
//         $this->pv = $pv;
//         if ($pv < 0) {
//             $this->pv = 0;
//         }
//         if ($pv > self::MAXHP) {
//             $this->pv = self::MAXHP;
//         }

    //     }
//     public function setAtk($attaque)
//     {
//         return $this->attaque = $attaque;
//     }
//     public function setId($id)
//     {
//         return $this->id = $id;
//     }
//     public function setNom($nom)
//     {
//         return $this->nom = $nom;
//     }
//     public function setImg(?string $img): void {
//         $this->img = $img;
//     }

}
?>