<?php
// Démarrer la session
session_start();

// Inclure la connexion et la classe Liste
require_once 'classes/database.class.php';
require_once 'classes/liste.class.php';

// Vérifier si l'ID est présent et non vide
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);

    // Instancier la classe Liste
    $liste = new Liste();

    // Vérifier si le produit existe
    if (!$liste->getById($id)) {
        $_SESSION['erreur'] = "Cet ID n'existe pas";
    } else {
        // Supprimer le produit
        if ($liste->delete($id)) {
            $_SESSION['message'] = "Produit supprimé";
        } else {
            $_SESSION['erreur'] = "Erreur lors de la suppression";
        }
    }
    
    header('Location: index.php');
    exit;
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
    exit;
}
?>
