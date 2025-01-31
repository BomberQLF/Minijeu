<?php
class CountryManager
{
    private $db;
    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function setDb(PDO $db): void
    {
        $this->db = $db;
    }

    public function getAllCountries(): array
    {
        $requete = 'SELECT id, nom, image FROM pays ORDER BY nom'; 
        $stmt = $this->db->query($requete);
    
        $countries = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $countries[] = new Country($row);
        }
    
        return $countries;
    }

    public function getCountryByName($name)
    {
        $requete = 'SELECT * FROM pays WHERE nom = :nom';
        $stmt = $this->db->prepare($requete);
        $stmt->bindParam(':nom', $name, PDO::PARAM_STR);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return new Country($result);
        } else {
            return null;
        }
    }

    public function saveCountryToPlayer($player, $country)
{
    if ($player == 'player1') {
        $_SESSION['player1'] = $country;
    } elseif ($player == 'player2') {
        $_SESSION['player2'] = $country;
    }
}

    public function createCountry($nom, $atk, $pv, $armor)
    {
        $requete = "INSERT INTO blinde (nom, atk, pv, armor) VALUES (:nom, :atk, :pv, :armor)";
        $stmt = $this->db->prepare($requete);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':atk', $atk, PDO::PARAM_INT);
        $stmt->bindParam(':pv', $pv, PDO::PARAM_INT);
        $stmt->bindParam(':armor', $armor, PDO::PARAM_INT);
        $stmt->execute();
    }
}

?>