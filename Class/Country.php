<?php

class Country
{
    private int $id = 0;
    private string $nom = "";
    private int $pv = 0;
    private int $attaque = 0;
    private ?string $image = null;
    public const MAXHP = 100;
    private static $compteur = 0;


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

    public function nomPersonnage($nom)
    {
        $this->nom = $nom;
        return 'Votre personnage s\'appelle ' . $this->nom;
    }

    public function renforcer($soin = null)
    {
        if (is_null($soin)) {
            $this->pv = 100;
        } else {
            $this->pv += $soin;
            return 'Vos point de vie son de ' . $this->pv;
        }
    }

    public function tirer(Country $perso)
    {
        $perso->pv -= $this->attaque;
    }
    
    public function is_alive()
    {
        // if ($this->hp <=0 ) {
        //     return $this->nom .' est mort';
        // }else {
        //     return $this->nom.' a '.$this->hp .'PV';
        // }
        return $this->pv <= 0;
    }

    //Constante





    // GETTERS

    public static function getCompteur()
    {
        return self::$compteur;
    }

    public function getHp()
    {
        return $this->pv;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAtk()
    {
        return $this->attaque;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getImg(): string
    {
        return $this->image ?: "https://via.placeholder.com/150";
    }

    // SETTERS

    public function setHp($pv)
    {
        $this->pv = $pv;
        if ($pv < 0) {
            $this->pv = 0;
        }
        if ($pv > self::MAXHP) {
            $this->pv = self::MAXHP;
        }

    }
    public function setAtk($attaque)
    {
        return $this->attaque = $attaque;
    }
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function setNom($nom)
    {
        return $this->nom = $nom;
    }
    public function setImg(?string $img): void {
        $this->img = $img;
    }

}
?>