<?php
session_start();

// Connexion à la BDD
$db = new PDO('mysql:host=localhost;dbname=battle_nations', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Autoloader des classes
function chargerClasse($classe) {
    require './Class/' . $classe . '.php';
}
spl_autoload_register('chargerClasse');

// Vérification des joueurs en session
if (!isset($_SESSION['player1'])) {
    $_SESSION['player1'] = null;
}

if (!isset($_SESSION['player2'])) {
    $_SESSION['player2'] = null;
}

// Gestionnaire de pays
$manager = new CountryManager($db);

// Vérification de l'action
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'country1':
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['nom'])) {
            $selectedCountry = $manager->getCountryByName($_POST['nom']);
            if ($selectedCountry) {
                $_SESSION['player1'] = serialize($selectedCountry);
            }
        }
        break;

    case 'country2':
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['nom'])) {
            $selectedCountry = $manager->getCountryByName($_POST['nom']);
            if ($selectedCountry) {
                $_SESSION['player2'] = serialize($selectedCountry);
            }
        }
        break;
}

// Récupération des pays sélectionnés (en évitant __PHP_Incomplete_Class)
$player1 = (isset($_SESSION['player1']) && is_string($_SESSION['player1'])) ? unserialize($_SESSION['player1']) : null;
$player2 = (isset($_SESSION['player2']) && is_string($_SESSION['player2'])) ? unserialize($_SESSION['player2']) : null;

// Liste des pays disponibles
$countryNames = $manager->getAllCountries();

// Debugging (facultatif)
var_dump($player1 ? $player1->getNom() : "Aucun pays sélectionné pour Player 1");
var_dump($player2 ? $player2->getNom() : "Aucun pays sélectionné pour Player 2");
var_dump($player1 ? $player1->getId() : "Aucun pays sélectionné pour Player 1");

// Affichage de la vue
include("./Vue/home.php");
?>