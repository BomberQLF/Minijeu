<!-- FAIRE UN MINIJEU SUR LE THÈME DES PAYS/NATION - CAPACITÉ MILITAIRE/NOTORIÉTÉ/PUISSANCE/DEFENSE -->
<!-- FAIRE UN MINIJEU SUR LE THÈME DES PAYS/NATION - CAPACITÉ MILITAIRE/NOTORIÉTÉ/PUISSANCE/DEFENSE -->
<!-- FAIRE UN MINIJEU SUR LE THÈME DES PAYS/NATION - CAPACITÉ MILITAIRE/NOTORIÉTÉ/PUISSANCE/DEFENSE -->
<!-- FAIRE UN MINIJEU SUR LE THÈME DES PAYS/NATION - CAPACITÉ MILITAIRE/NOTORIÉTÉ/PUISSANCE/DEFENSE -->
<!-- FAIRE UN MINIJEU SUR LE THÈME DES PAYS/NATION - CAPACITÉ MILITAIRE/NOTORIÉTÉ/PUISSANCE/DEFENSE -->
<!-- FAIRE UN MINIJEU SUR LE THÈME DES PAYS/NATION - CAPACITÉ MILITAIRE/NOTORIÉTÉ/PUISSANCE/DEFENSE -->
<!-- FAIRE UN MINIJEU SUR LE THÈME DES PAYS/NATION - CAPACITÉ MILITAIRE/NOTORIÉTÉ/PUISSANCE/DEFENSE -->
<!-- FAIRE UN MINIJEU SUR LE THÈME DES PAYS/NATION - CAPACITÉ MILITAIRE/NOTORIÉTÉ/PUISSANCE/DEFENSE -->


<?php
$db = new PDO('mysql:host=localhost;dbname=poo_jeu', 'root', 'root');
function chargerClasse($classe) {
    require 'Class/'.$classe.'.php';
}

spl_autoload_register('chargerClasse');
$monManager = new PersonnageManager($db);
$personnages = $monManager->getAllPersonnages();
$perso2 = $monManager->getOnePersonnageById(2);
var_dump($perso2);
?>


<form action="" method="POST">
    <label for="nom">Nom</label>
    <input type="text" name="nom" placeholder="Nom">

    <label for="atk">Dégats</label>
    <input type="text" name="atk" placeholder="Dégats">

    <label for="pv">PV</label>
    <input type="text" name="pv" placeholder="PV">

    <label for="armor">Armor</label>
    <input type="text" name="armor">

    <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["nom"]) && !empty($_POST["atk"]) && !empty($_POST["pv"]) && !empty($_POST["armor"])) {
        $nom = htmlspecialchars($_POST["nom"]);
        $atk = (int) $_POST["atk"];
        $pv = (int) $_POST["pv"];
        $armor = (int) $_POST["armor"];

        $tankManager = new PersonnageManager($db);
        $tankManager->createTank($nom, $atk, $pv, $armor);
        
        echo "Tank créé avec succès !";
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>

<!-- FAIRE DE CE FICHIER LE CONTROLLER ET CRÉER UNE VUE QU'ON APPELLE PAR DÉFAUT -->
<!-- FAIRE DE CE FICHIER LE CONTROLLER ET CRÉER UNE VUE QU'ON APPELLE PAR DÉFAUT -->
<!-- FAIRE DE CE FICHIER LE CONTROLLER ET CRÉER UNE VUE QU'ON APPELLE PAR DÉFAUT -->
<!-- FAIRE DE CE FICHIER LE CONTROLLER ET CRÉER UNE VUE QU'ON APPELLE PAR DÉFAUT -->
