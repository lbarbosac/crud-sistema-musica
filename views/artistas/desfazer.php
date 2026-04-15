<?php
session_start();
require_once '../../repositories/ArtistaRepository.php';
require_once '../../configs/database.php';

$conn = (new Database())->connect();

if(isset($_SESSION['undo']) && $_SESSION['undo']['tipo'] == 'artista'){

    $repo = new ArtistaRepository();
    $dados = $_SESSION['undo']['dados'];

    // recria artista
    $repo->criar($dados['nome']);

    // pega ID correto (garantido)
    $stmt = $conn->query("SELECT MAX(ArtistaID) as id FROM artistas");
    $novoId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

    // restaura músicas
    foreach($_SESSION['undo']['musicas'] as $m){
        $stmt = $conn->prepare("
            UPDATE musicas 
            SET ArtistaID = :artista 
            WHERE MusicaID = :musica
        ");
        $stmt->execute([
            ':artista' => $novoId,
            ':musica' => $m['MusicaID']
        ]);
    }

    unset($_SESSION['undo']);
}

header("Location: listar.php");