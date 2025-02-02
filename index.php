<?php
session_start();

// Connexion à la BDD
$db = new PDO('mysql:host=localhost;dbname=battle_nations', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Autoloader des classes
function chargerClasse($classe)
{
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

// Récupération des pays sélectionnés 
$player1 = (isset($_SESSION['player1']) && is_string($_SESSION['player1'])) ? unserialize($_SESSION['player1']) : null;
$player2 = (isset($_SESSION['player2']) && is_string($_SESSION['player2'])) ? unserialize($_SESSION['player2']) : null;

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

    case 'addCountry':
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (
                isset($_POST['nom'], $_POST['attaque'], $_POST['renforcement'], $_POST['bombe_nucleaire'], $_POST['pv']) &&
                $_POST['nom'] !== '' &&
                $_POST['attaque'] !== '' &&
                $_POST['renforcement'] !== '' &&
                $_POST['bombe_nucleaire'] !== '' &&
                $_POST['pv'] !== '' &&
                is_numeric($_POST['attaque']) &&
                is_numeric($_POST['renforcement']) &&
                is_numeric($_POST['bombe_nucleaire']) &&
                is_numeric($_POST['pv'])
            ) {

                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['image']['tmp_name'];
                    $fileName = $_FILES['image']['name'];
                    $fileSize = $_FILES['image']['size'];
                    $fileType = $_FILES['image']['type'];

                    $uploadDir = 'uploads/';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $fileNameNew = uniqid("{$_POST['nom']}_", true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                    $destPath = $uploadDir . $fileNameNew;
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $imagePath = $destPath;
                    } else {
                        echo "Error while uploading the image.";
                        exit;
                    }
                } else {
                    $imagePath = null; 
                }

                // Appel de la méthode pour ajouter le pays
                $manager->createCountry(
                    $_POST['nom'],
                    $_POST['attaque'],
                    $_POST['renforcement'],
                    $_POST['bombe_nucleaire'],
                    $_POST['pv'],
                    $imagePath 
                );
                echo "Country Added";
            } else {
                echo "Please fill in all fields correctly.";
            }
        } else {
            echo "Invalid request method.";
        }
        break;

    case 'play' : 
        include('./Vue/battle.php');
        exit;
}

// VARIABLES GLOBALES POUR MANIPULER LES DONNÉES DES PAYS
$reinforcement1 = ($player1) ? $player1->getRenforcement() : null;
$reinforcement2 = ($player2) ? $player2->getRenforcement() : null;

$attack1 = ($player1) ? $player1->getAttaque() : null;
$attack2 = ($player2) ? $player2->getAttaque() : null;

$nuclearBombs1 = ($player1) ? $player1->getBombe_nucleaire() : null;
$nuclearBombs2 = ($player2) ? $player2->getBombe_nucleaire() : null;

$pv1 = ($player1) ? $player1->getPv() : null;
$pv2 = ($player2) ? $player2->getPv() : null;

$image1 = ($player1) ? $player1->getImage() : null;
$image2 = ($player2) ? $player2->getImage() : null;

// Liste des pays disponibles
$countryNames = $manager->getAllCountries();

// Affichage de la vue
include("./Vue/home.php");

?>