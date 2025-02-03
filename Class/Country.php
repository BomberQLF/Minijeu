<?php

class Country
{
    public const MAXHP = 1000;
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
        // On s'assure que les points de vie restent entre 0 et MAXHP
        if ($pv > self::MAXHP) {
            $this->pv = self::MAXHP;
        } elseif ($pv < 0) {
            $this->pv = 0;
        } else {
            $this->pv = $pv;
        }
    }
    public function setImage(?string $image)
    {
        $this->image = $image;
    }

    // METHODS

    // Infliger des dégâts à un autre pays, en s'assurant que le PV ne descende pas en dessous de 0
    public function invade(Country $country)
    {
        $newPv = $country->getPv() - $this->attaque;
        $country->setPv($newPv);
    }

    // Renforcer un pays, sans dépasser MAXHP
    public function reinforce(Country $country)
    {
        $newPv = $country->getPv() + $this->renforcement;
        $country->setPv($newPv);
    }

    // Lancer une bombe nucléaire sur un pays, en s'assurant que le PV ne descende pas en dessous de 0
    public function nuclearBomb(Country $country)
    {
        $newPv = $country->getPv() - 100;
        $country->setPv($newPv);
    }
}
?>