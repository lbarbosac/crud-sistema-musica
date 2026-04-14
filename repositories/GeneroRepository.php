<?php
require_once __DIR__ . '/../configs/database.php';

class GeneroRepository {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function listar() {
        return $this->conn
            ->query("SELECT * FROM generos ORDER BY GeneroID ASC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id) {
        $stmt = $this->conn->prepare("SELECT * FROM generos WHERE GeneroID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($nome) {
        $stmt = $this->conn->prepare("INSERT INTO generos (nome) VALUES (?)");
        return $stmt->execute([$nome]);
    }

    public function atualizar($id, $nome) {
        $stmt = $this->conn->prepare("UPDATE generos SET nome = ? WHERE GeneroID = ?");
        return $stmt->execute([$nome, $id]);
    }

    public function contarMusicas($id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM musicas WHERE GeneroID = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public function removerVinculoMusicas($id) {
        $stmt = $this->conn->prepare("UPDATE musicas SET GeneroID = NULL WHERE GeneroID = ?");
        return $stmt->execute([$id]);
    }

    public function deletar($id) {
        $stmt = $this->conn->prepare("DELETE FROM generos WHERE GeneroID = ?");
        return $stmt->execute([$id]);
    }
}