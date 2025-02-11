<?php
require_once 'database.class.php';

class Liste {
    private $conn;
    private $table = "liste"; // Correspond au nom de ta table

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    // Récupérer tous les produits
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un produit par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Activer/Désactiver un produit par ID
    public function toggleActif($id) {
        $produit = $this->getById($id);

        if (!$produit) {
            return false; // L'ID n'existe pas
        }

        $nouvelEtat = ($produit['actif'] == 0) ? 1 : 0;

        $query = "UPDATE " . $this->table . " SET actif = :actif WHERE id = :id";
        $stmt = $this->conn->prepare($query); // Correction ici (avant, `$sql` n'existait pas)
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':actif', $nouvelEtat, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Ajouter un produit
    public function create($produit, $prix, $nombre) {
        $query = "INSERT INTO " . $this->table . " (produit, prix, nombre, actif) VALUES (:produit, :prix, :nombre, 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":produit", $produit);
        $stmt->bindParam(":prix", $prix);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Mettre à jour un produit
    public function update($id, $produit, $prix, $nombre) {
        $query = "UPDATE " . $this->table . " SET produit = :produit, prix = :prix, nombre = :nombre WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":produit", $produit);
        $stmt->bindParam(":prix", $prix);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_INT);
        //$stmt->bindParam(":actif", $actif, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Supprimer un produit
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
