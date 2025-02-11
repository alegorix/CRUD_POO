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

    // Récupérer le produit
    $produit = $liste->getById($id);

    // Vérifier si le produit existe
    if (!$produit) {
        $_SESSION['erreur'] = "Cet ID n'existe pas";
        header('Location: index.php');
        exit;
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du produit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails du produit <?= htmlspecialchars($produit['produit']) ?></h1>
                <p>ID : <?= htmlspecialchars($produit['id']) ?></p>
                <p>Produit : <?= htmlspecialchars($produit['produit']) ?></p>
                <p>Prix : <?= htmlspecialchars($produit['prix']) ?></p>
                <p>Nombre : <?= htmlspecialchars($produit['nombre']) ?></p>
                <p><a href="index.php">Retour</a> <a href="edit.php?id=<?= htmlspecialchars($produit['id']) ?>">Modifier</a></p>
            </section>
        </div>
    </main>
</body>
</html>
