<?php
session_start();
// Connection BDD.
$db = new PDO('mysql:host=localhost;dbname=battle_nations', 'root', 'root');
require_once('./Class/Country.php');

// Autoloader
function chargerClasse($classe) {
    require 'Class/'.$classe.'.php';
}
spl_autoload_register('chargerClasse');


if (!isset($_SESSION['player1'])) {
    $_SESSION['player1'] = null;
}

if (!isset($_SESSION['player2'])) {
    $_SESSION['player2'] = null;
}

// Controller - Action
$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
    // case 'value':
    //     # code...
    //     break;q
    
    default:
    $countryManager = new CountryManager($db);
    $countryNames = $countryManager->getAllCountries();
    include("./Vue/home.php");
    break;
}