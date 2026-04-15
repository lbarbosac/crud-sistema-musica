<?php
require_once __DIR__ . '/../configs/database.php';
require_once __DIR__ . '/../models/Musica.php';

class MusicaRepository {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
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

    public function criar($dados) {
        $sql = "INSERT INTO musicas (titulo, duracao, AnoLancamento, ArtistaID, GeneroID)
                VALUES (:titulo, :duracao, :ano, :artista, :genero)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':titulo' => $dados['titulo'],
            ':duracao' => $dados['duracao'],
            ':ano' => $dados['AnoLancamento'],
            ':artista' => $dados['ArtistaID'] ?: null,
            ':genero' => $dados['GeneroID'] ?: null
        ]);
    }

    public function buscar($id) {
        $stmt = $this->conn->prepare("SELECT * FROM musicas WHERE MusicaID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($dados) {
        $sql = "UPDATE musicas SET 
                titulo = :titulo,
                duracao = :duracao,
                AnoLancamento = :ano,
                ArtistaID = :artista,
                GeneroID = :genero
                WHERE MusicaID = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':titulo' => $dados['titulo'],
            ':duracao' => $dados['duracao'],
            ':ano' => $dados['AnoLancamento'],
            ':artista' => $dados['ArtistaID'] ?: null,
            ':genero' => $dados['GeneroID'] ?: null,
            ':id' => $dados['MusicaID']
        ]);
    }

    public function deletar($id) {
        $stmt = $this->conn->prepare("DELETE FROM musicas WHERE MusicaID = ?");
        return $stmt->execute([$id]);
    }
}