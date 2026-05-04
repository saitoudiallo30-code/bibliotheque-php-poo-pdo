<?php
class Auteur {
    private $conn;
    private $table = "auteurs";

    public $id;
    public $nom;
    public $prenom;
    public $nationalite;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function lireTous() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nom ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function lireUn() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->nom = $row['nom'];
            $this->prenom = $row['prenom'];
            $this->nationalite = $row['nationalite'];
        }
    }

    public function creer() {
        $query = "INSERT INTO " . $this->table . " SET nom=:nom, prenom=:prenom, nationalite=:nationalite";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":nationalite", $this->nationalite);
        return $stmt->execute();
    }

    public function modifier() {
        $query = "UPDATE " . $this->table . " SET nom=:nom, prenom=:prenom, nationalite=:nationalite WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":nationalite", $this->nationalite);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function supprimer() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();

    }
    
}