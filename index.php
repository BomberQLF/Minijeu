<?php
// Connection BDD
$db = new PDO('mysql:host=localhost;dbname=battle_nations', 'root', 'root');

// Autoloader
function chargerClasse($classe) {
    require 'Class/'.$classe.'.php';
}
spl_autoload_register('chargerClasse');

// Instancier le manager
$monManager = new PersonnageManager($db);


// Controller - Action
$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
    // case 'value':
    //     # code...
    //     break;
    
    default:
        include("./Vue/home.php");
        break;
}