<?php
// Démarrer la session
session_start();

// Inclure la connexion et la classe Liste
require_once 'classes/database.class.php';
require_once 'classes/liste.class.php';

// Instancier la classe Liste
$liste = new Liste();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['id']) && !empty($_POST['produit']) && !empty($_POST['prix']) && !empty($_POST['nombre'])) {
        
        // Nettoyage des données
        $id = strip_tags($_POST['id']);
        $produit = strip_tags($_POST['produit']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);

        // Mettre à jour le produit
        if ($liste->update($id, $produit, $prix, $nombre, 1)) { // 1 par défaut pour 'actif'
            $_SESSION['message'] = "Produit modifié avec succès";
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['erreur'] = "Erreur lors de la mise à jour";
        }
    } else {
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Vérifier si l'ID est présent et non vide dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $produit = $liste->getById($id);

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
    <title>Modifier un produit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php if (!empty($_SESSION['erreur'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['erreur']; $_SESSION['erreur'] = ""; ?>
                    </div>
                <?php endif; ?>
                
                <h1>Modifier un produit</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="produit">Produit</label>
                        <input type="text" id="produit" name="produit" class="form-control" value="<?= htmlspecialchars($produit['produit']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input type="text" id="prix" name="prix" class="form-control" value="<?= htmlspecialchars($produit['prix']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="number" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($produit['nombre']) ?>">
                    </div>
                    <input type="hidden" value="<?= htmlspecialchars($produit['id']) ?>" name="id">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
