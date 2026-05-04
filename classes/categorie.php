<?php
class Categorie {
    private $conn;
    private $table = "categories";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM $this->table");
    }

    public function create($libelle) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table VALUES (NULL, ?)");
        return $stmt->execute([$libelle]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id=?");
        return $stmt->execute([$id]);
    }
}