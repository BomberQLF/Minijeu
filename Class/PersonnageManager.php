<?php
class PersonnageManager
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

    public function getAllPersonnages(): array
    {
        $requete = 'SELECT * FROM blinde ORDER BY nom';
        $stmt = $this->db->query($requete);

        while ($perso = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $personnages[] = new Personnage($perso);
        }
        return $personnages;
    }

    public function getOnePersonnageById($id): ?Personnage
    {
        $requete = 'SELECT * FROM blinde WHERE id=:id';
        $stmt = $this->db->prepare($requete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Créer un personnage avec les données récupérées
            $personnage = new Personnage($result);
            return $personnage;
        } else {
            return null;
        }
    }

    public function createTank($nom, $atk, $pv, $armor)
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