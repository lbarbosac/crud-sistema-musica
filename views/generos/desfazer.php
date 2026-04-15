<?php
session_start();
require_once '../../repositories/GeneroRepository.php';
require_once '../../configs/database.php';

$conn = (new Database())->connect();

if(isset($_SESSION['undo']) && $_SESSION['undo']['tipo'] == 'genero'){

    $repo = new GeneroRepository();
    $dados = $_SESSION['undo']['dados'];

    try {
        $conn->beginTransaction();

        // recria gênero
        $stmt = $conn->prepare("INSERT INTO generos (nome) VALUES (?)");
        $stmt->execute([$dados['nome']]);

        // pega ID correto
        $novoId = $conn->lastInsertId();

        // restaura músicas
        foreach($_SESSION['undo']['musicas'] as $m){
            $stmt = $conn->prepare("
                UPDATE musicas 
                SET GeneroID = ? 
                WHERE MusicaID = ?
            ");
            $stmt->execute([$novoId, $m['MusicaID']]);
        }

        $conn->commit();
        unset($_SESSION['undo']);

    } catch (Exception $e) {
        $conn->rollBack();
        die("Erro ao desfazer: " . $e->getMessage());
    }
}

header("Location: listar.php");