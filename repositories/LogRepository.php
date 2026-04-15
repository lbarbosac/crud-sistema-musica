<?php
require_once __DIR__ . '/../configs/database.php';

class LogRepository {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function registrar($usuario_id, $acao, $tabela, $registro_id, $antes = null, $depois = null) {
        $sql = "INSERT INTO audit_logs 
                (usuario_id, acao, tabela, registro_id, dados_antes, dados_depois)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $usuario_id,
            $acao,
            $tabela,
            $registro_id,
            json_encode($antes),
            json_encode($depois)
        ]);
    }

    public function listar() {
        return $this->conn->query("
            SELECT l.*, u.nome 
            FROM audit_logs l
            LEFT JOIN usuarios u ON l.usuario_id = u.UsuarioID
            ORDER BY l.criado_em DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
}