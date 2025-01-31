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
        $requete = 'SELECT id, nom, attaque, renforcement, bombe_nucleaire, pv, image FROM pays ORDER BY nom'; 
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

    // Fonction save country to player session
    public function saveCountryToPlayer($player, $countryName)
    {
        $country = $this->getCountryByName($countryName);
    
        if ($country) {
            if ($player == 'player1') {
                $_SESSION['player1'] = serialize($country);
            } elseif ($player == 'player2') {
                $_SESSION['player2'] = serialize($country);
            }
        }
    }

    public function createCountry($nom, $atk, $renforcement, $bombe_nucleaire, $pv, $image)
    {
        $requete = "INSERT INTO pays (nom, attaque, renforcement, bombe_nucleaire, pv, image) 
                    VALUES (:nom, :atk, :renforcement, :bombe_nucleaire, :pv, :image)";
        $stmt = $this->db->prepare($requete);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':atk', $atk, PDO::PARAM_INT);
        $stmt->bindParam(':renforcement', $renforcement, PDO::PARAM_INT);
        $stmt->bindParam(':bombe_nucleaire', $bombe_nucleaire, PDO::PARAM_INT);
        $stmt->bindParam(':pv', $pv, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function updateCountry($id, $nom, $atk, $renforcement, $bombe_nucleaire, $pv, $image)
    {
        $requete = "UPDATE pays SET nom = :nom, attaque = :atk, renforcement = :renforcement, 
                    bombe_nucleaire = :bombe_nucleaire, pv = :pv, image = :image WHERE id = :id";
        $stmt = $this->db->prepare($requete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':atk', $atk, PDO::PARAM_INT);
        $stmt->bindParam(':renforcement', $renforcement, PDO::PARAM_INT);
        $stmt->bindParam(':bombe_nucleaire', $bombe_nucleaire, PDO::PARAM_INT);
        $stmt->bindParam(':pv', $pv, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteCountry($id)
    {
        $requete = 'DELETE FROM pays WHERE id = :id';
        $stmt = $this->db->prepare($requete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>