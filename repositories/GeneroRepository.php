<?php
require_once __DIR__ . '/../configs/database.php';
require_once __DIR__ . '/../models/Genero.php';

class GeneroRepository {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function listar() {
        $stmt = $this->conn->query("SELECT * FROM generos ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar($nome) {
        $stmt = $this->conn->prepare("INSERT INTO generos (nome) VALUES (?)");
        return $stmt->execute([$nome]);
    }

    public function buscar($id) {
        $stmt = $this->conn->prepare("SELECT * FROM generos WHERE GeneroID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $nome) {
        $stmt = $this->conn->prepare("UPDATE generos SET nome = ? WHERE GeneroID = ?");
        return $stmt->execute([$nome, $id]);
    }

    public function deletar($id) {
        $stmt = $this->conn->prepare("DELETE FROM generos WHERE GeneroID = ?");
        return $stmt->execute([$id]);
    }
}