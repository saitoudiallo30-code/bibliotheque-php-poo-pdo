<?php


class Categorie {

    private $conn;
    private $table = "categories";
    public $id, $libelle;
    public function __construct($db) { $this->conn = $db; }
    public function lireTous() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY libelle ASC");
        $stmt->execute();
        return $stmt;

    }


    public function lireUn() {

        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1");
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) { $this->libelle = $row['libelle']; }

    }



    public function creer() {

        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " SET libelle=:libelle");
        $stmt->bindParam(":libelle", $this->libelle);
        return $stmt->execute();

    }


    public function modifier() {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET libelle=:libelle WHERE id=:id");
        $stmt->bindParam(":libelle", $this->libelle);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();

    }


    public function supprimer() {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id = ?");
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();

    }
    
}