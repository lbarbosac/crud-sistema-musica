<?php
require_once __DIR__ . '/../configs/database.php';

class MusicaRepository {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function listar() {
        $sql = "SELECT 
                    m.MusicaID,
                    m.titulo,
                    m.duracao,
                    m.AnoLancamento,
                    a.nome AS artista,
                    g.nome AS genero
                FROM musicas m
                LEFT JOIN artistas a ON m.ArtistaID = a.ArtistaID
                LEFT JOIN generos g ON m.GeneroID = g.GeneroID
                ORDER BY m.MusicaID ASC";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id) {
        $stmt = $this->conn->prepare("SELECT * FROM musicas WHERE MusicaID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($dados) {
        $stmt = $this->conn->prepare("
            INSERT INTO musicas 
            (titulo, duracao, AnoLancamento, ArtistaID, GeneroID)
            VALUES (?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $dados['titulo'],
            $dados['duracao'],
            $dados['ano'],
            $dados['ArtistaID'] ?: null,
            $dados['GeneroID'] ?: null
        ]);
    }

    public function atualizar($id, $dados) {
        $stmt = $this->conn->prepare("
            UPDATE musicas 
            SET titulo = ?, duracao = ?, AnoLancamento = ?, ArtistaID = ?, GeneroID = ?
            WHERE MusicaID = ?
        ");

        return $stmt->execute([
            $dados['titulo'],
            $dados['duracao'],
            $dados['ano'],
            $dados['ArtistaID'] ?: null,
            $dados['GeneroID'] ?: null,
            $id
        ]);
    }

    public function deletar($id) {
        $stmt = $this->conn->prepare("DELETE FROM musicas WHERE MusicaID = ?");
        return $stmt->execute([$id]);
    }
}