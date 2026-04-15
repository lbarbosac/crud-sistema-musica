<?php
session_start();
require_once '../../repositories/GeneroRepository.php';
require_once '../../configs/database.php';

$conn = (new Database())->connect();

if(isset($_SESSION['undo']) && $_SESSION['undo']['tipo'] == 'genero'){

    $repo = new GeneroRepository();
    $dados = $_SESSION['undo']['dados'];

    $repo->criar($dados['nome']);
    $novoId = $conn->lastInsertId();

    foreach($_SESSION['undo']['musicas'] as $m){
        $stmt = $conn->prepare("UPDATE musicas SET GeneroID = ? WHERE MusicaID = ?");
        $stmt->execute([$novoId, $m['MusicaID']]);
    }

    unset($_SESSION['undo']);
}

header("Location: listar.php");