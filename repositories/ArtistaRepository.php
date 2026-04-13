<?php
require_once __DIR__ . '/../configs/database.php';
require_once __DIR__ . '/../models/Artista.php';

class ArtistaRepository {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function listar() {
        $stmt = $this->conn->query("SELECT * FROM artistas ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar($nome) {
        $stmt = $this->conn->prepare("INSERT INTO artistas (nome) VALUES (?)");
        return $stmt->execute([$nome]);
    }

    public function buscar($id) {
        $stmt = $this->conn->prepare("SELECT * FROM artistas WHERE ArtistaID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $nome) {
        $stmt = $this->conn->prepare("UPDATE artistas SET nome = ? WHERE ArtistaID = ?");
        return $stmt->execute([$nome, $id]);
    }

    public function deletar($id) {
        $stmt = $this->conn->prepare("DELETE FROM artistas WHERE ArtistaID = ?");
        return $stmt->execute([$id]);
    }
}