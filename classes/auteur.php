<?php
class Auteur {
    private $conn;
    private $table = "auteurs";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM $this->table");
    }

    public function create($nom, $prenom, $nationalite) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table VALUES (NULL, ?, ?, ?)");
        return $stmt->execute([$nom, $prenom, $nationalite]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom, $prenom, $nationalite) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET nom=?, prenom=?, nationalite=? WHERE id=?");
        return $stmt->execute([$nom, $prenom, $nationalite, $id]);
    }
}