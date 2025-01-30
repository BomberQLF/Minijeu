<?php

class Personnage
{
    private int $id = 0;
    private string $nom = "";
    private int $hp = 0;
    private int $atk = 0;
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

    public function crier()
    {
        return 'Vous ne passerez pas !';
    }

    public function reparer($soin = null)
    {
        if (is_null($soin)) {
            $this->hp = 100;
        } else {
            $this->hp += $soin;
            return 'Vos point de vie son de ' . $this->hp;
        }

    }

    public function is_alive()
    {
        // if ($this->hp <=0 ) {
        //     return $this->nom .' est mort';
        // }else {
        //     return $this->nom.' a '.$this->hp .'PV';
        // }
        return $this->hp <= 0;
    }

    public function tirer(Personnage $perso)
    {
        $perso->hp -= $this->atk;
    }

    //Constante





    // GETTERS

    public static function getCompteur()
    {
        return self::$compteur;
    }

    public function getHp()
    {
        return $this->hp;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAtk()
    {
        return $this->atk;
    }
    public function getNom()
    {
        return $this->nom;
    }

    // SETTERS

    public function setHp($hp)
    {
        $this->hp = $hp;
        if ($hp < 0) {
            $this->hp = 0;
        }
        if ($hp > self::MAXHP) {
            $this->hp = self::MAXHP;
        }

    }
    public function setAtk($atk)
    {
        return $this->atk = $atk;
    }
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function setNom($nom)
    {
        return $this->nom = $nom;
    }

}
?>