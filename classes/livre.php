<?php
class Livre {
    private $conn;
    private $table = "livres";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT l.*, a.nom AS auteur, c.libelle AS categorie
                FROM livres l
                LEFT JOIN auteurs a ON l.auteur_id = a.id
                LEFT JOIN categories c ON l.categorie_id = c.id";

        return $this->conn->query($sql);
    }

    public function create($titre, $isbn, $annee, $quantite, $auteur, $categorie) {
        $stmt = $this->conn->prepare(
            "INSERT INTO livres (titre,isbn,annee,quantite,auteur_id,categorie_id)
             VALUES (?,?,?,?,?,?)"
        );

        return $stmt->execute([$titre,$isbn,$annee,$quantite,$auteur,$categorie]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM livres WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM livres WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id,$titre,$isbn,$annee,$quantite) {
        $stmt = $this->conn->prepare(
            "UPDATE livres SET titre=?,isbn=?,annee=?,quantite=? WHERE id=?"
        );
        return $stmt->execute([$titre,$isbn,$annee,$quantite,$id]);
    }
}