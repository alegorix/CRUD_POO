<?php
// Démarrer la session
session_start();

// Inclure la connexion et la classe
require_once ('classes/database.class.php');
require_once ('classes/liste.class.php');

// Vérifier si l'ID est présent et non vide
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);

    $liste = new Liste(); // Pas besoin de passer $db, car il est géré en interne

    // Changer l'état actif/inactif
    if (!$liste->toggleActif($id)) {
        $_SESSION['erreur'] = "Cet ID n'existe pas";
    }

    header('Location: index.php');
    exit;
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
    exit;
}
?>
