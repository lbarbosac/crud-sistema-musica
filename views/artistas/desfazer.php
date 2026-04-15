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

    // pega novo ID criado
    $novoId = $conn->lastInsertId();

    // restaura músicas
    foreach($_SESSION['undo']['musicas'] as $m){
        $stmt = $conn->prepare("UPDATE musicas SET ArtistaID = ? WHERE MusicaID = ?");
        $stmt->execute([$novoId, $m['MusicaID']]);
    }

    unset($_SESSION['undo']);
}

header("Location: listar.php");