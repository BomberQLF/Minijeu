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

// Je n'arrivais pas à fix un bug qui empêchait la sélection des pays pour les deux joueurs après avoir reset la session (après une partie gagnée)
if (!isset($_SESSION['player1']) || is_null($_SESSION['player1'])) {
    $data1 = [
        'id' => 1,
        'nom' => 'France',
        'attaque' => 50,
        'renforcement' => 20,
        'bombe_nucleaire' => 1,
        'pv' => 1000,
        'image' => 'https://flagcdn.com/w320/fr.png'
    ];
    $player1 = new Country($data1);
    $_SESSION['player1'] = serialize($player1);
} else {
    $player1 = (is_string($_SESSION['player1'])) ? unserialize($_SESSION['player1']) : null;
}

if (!isset($_SESSION['player2']) || is_null($_SESSION['player2'])) {
    $data2 = [
        'id' => 2,
        'nom' => 'Russie',
        'attaque' => 45,
        'renforcement' => 35,
        'bombe_nucleaire' => 1,
        'pv' => 1000,
        'image' => 'https://flagcdn.com/w320/ru.png'
    ];
    $player2 = new Country($data2);
    $_SESSION['player2'] = serialize($player2);
} else {
    $player2 = (is_string($_SESSION['player2'])) ? unserialize($_SESSION['player2']) : null;
}

if ($player1 && !isset($_SESSION['pv1'])) {
    $_SESSION['pv1'] = $player1->getPv();
}
if ($player2 && !isset($_SESSION['pv2'])) {
    $_SESSION['pv2'] = $player2->getPv();
}

if ($player1 && $player2) {
    if ($player1->getPv() <= 0) {
        $_SESSION['winner'] = "Le gagnant est " . $player2->getNom();
    } elseif ($player2->getPv() <= 0) {
        $_SESSION['winner'] = "Le gagnant est " . $player1->getNom();
    }
}

// Gestionnaire de pays
$manager = new CountryManager($db);

// Vérification de l'action
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'play':
        // Recalculer player1 et player2 depuis la session
        $player1 = (isset($_SESSION['player1']) && is_string($_SESSION['player1'])) ? unserialize($_SESSION['player1']) : null;
        $player2 = (isset($_SESSION['player2']) && is_string($_SESSION['player2'])) ? unserialize($_SESSION['player2']) : null;
        if (!$player1 || !$player2) {
            header("Location: index.php");
            exit;
        }
        include('./Vue/battle.php');
        exit;

    case 'country1':
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['nom'])) {
            $selectedCountry = $manager->getCountryByName($_POST['nom']);
            if ($selectedCountry) {
                $_SESSION['player1'] = serialize($selectedCountry);
                // Réinitialiser le pv associé au nouveau pays
                $_SESSION['pv1'] = $selectedCountry->getPv();
                header("Location: index.php");
                exit;
            }
        }
        break;

    case 'country2':
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['nom'])) {
            $selectedCountry = $manager->getCountryByName($_POST['nom']);
            if ($selectedCountry) {
                $_SESSION['player2'] = serialize($selectedCountry);
                $_SESSION['pv2'] = $selectedCountry->getPv();
                header("Location: index.php");
                exit;
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

    case 'bombe_nucleaire':
        $target = $_GET['target'] ?? null;
        if ($target === 'player1' && $player2) {
            $player2->nuclearBomb($player1);
            $_SESSION['pv1'] = $player1->getPv();
            $_SESSION['nuclearBombs2'] = $player2->getBombe_nucleaire() - 1;
        } elseif ($target === 'player2' && $player1) {
            $player1->nuclearBomb($player2);
            $_SESSION['pv2'] = $player2->getPv();
            $_SESSION['nuclearBombs1'] = $player1->getBombe_nucleaire() - 1;
        }
        // Sauvegarder les objets mis à jour dans la session
        $_SESSION['player1'] = serialize($player1);
        $_SESSION['player2'] = serialize($player2);
        include('./Vue/battle.php');
        exit;

    case 'attaque':
        $target = $_GET['target'] ?? null;
        if ($target === 'player1' && $player2) {
            $player2->invade($player1);
            $_SESSION['pv1'] = $player1->getPv();
        } elseif ($target === 'player2' && $player1) {
            $player1->invade($player2);
            $_SESSION['pv2'] = $player2->getPv();
        }
        if ($player1 && $player2) {
            if ($player1->getPv() <= 0) {
                $_SESSION['winner'] = "Le gagnant est " . $player2->getNom();
            } elseif ($player2->getPv() <= 0) {
                $_SESSION['winner'] = "Le gagnant est " . $player1->getNom();
            }
        }
        $_SESSION['player1'] = serialize($player1);
        $_SESSION['player2'] = serialize($player2);
        include('./Vue/battle.php');
        exit;

    case 'renforcer':
        $target = $_GET['target'] ?? null;
        if ($target === 'player1' && $player1) {
            $player1->reinforce($player1);
            $_SESSION['pv1'] = $player1->getPv();
        } elseif ($target === 'player2' && $player2) {
            $player2->reinforce($player2);
            $_SESSION['pv2'] = $player2->getPv();
        }
        $_SESSION['player1'] = serialize($player1);
        $_SESSION['player2'] = serialize($player2);
        include('./Vue/battle.php');
        exit;

    case 'backoffice':
        include('./Vue/backoffice.php');
        exit;

    case 'deleteCountry':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $manager->deleteCountry($_POST['id']);
            header("Location: index.php?action=backoffice");
            exit;
        }
        break;

    case 'editCountry':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['nom'], $_POST['attaque'], $_POST['renforcement'], $_POST['bombe_nucleaire'], $_POST['pv'])) {
            $imagePath = '';

            // Check if an image was uploaded
            if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
                $imageTmpPath = $_FILES['image_upload']['tmp_name'];
                $imageName = basename($_FILES['image_upload']['name']);
                $imagePath = 'uploads/' . $imageName;

                // Move the uploaded file to the 'uploads' directory
                if (!move_uploaded_file($imageTmpPath, $imagePath)) {
                    // Handle upload error
                    echo "Erreur de téléchargement de l'image.";
                    exit;
                }
            } elseif (!empty($_POST['image_url'])) {
                // If no file uploaded, use the provided image URL
                $imagePath = $_POST['image_url'];
            }

            // Update country data with image URL or file path
            $manager->updateCountry($_POST['id'], $_POST['nom'], $_POST['attaque'], $_POST['renforcement'], $_POST['bombe_nucleaire'], $_POST['pv'], $imagePath);
            header("Location: index.php?action=backoffice");
            exit;
        } elseif (isset($_GET['id'])) {
            $country = $manager->getCountryByName($_GET['id']);
            include('./Vue/edit_country.php');
            exit;
        }
        break;

    case 'reset':
        unset($_SESSION['player1'], $_SESSION['player2'], $_SESSION['pv1'], $_SESSION['pv2'], $_SESSION['winner']);
        include('Vue/home.php');
        exit;
}

// VARIABLES GLOBALES POUR MANIPULER LES DONNÉES DES PAYS (si les objets existent)
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

// Affichage de la vue (par exemple home.php)
include("./Vue/home.php");
?>