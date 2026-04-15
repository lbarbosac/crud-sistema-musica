<?php
session_start();
require_once '../../repositories/GeneroRepository.php';
require_once '../../configs/database.php';

$conn = (new Database())->connect();
$repo = new GeneroRepository();

$id = $_GET['id'];

$genero = $repo->buscar($id);

// músicas afetadas
$stmt = $conn->prepare("SELECT MusicaID FROM musicas WHERE GeneroID = ?");
$stmt->execute([$id]);
$musicas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// salva
$_SESSION['undo'] = [
    'tipo' => 'genero',
    'dados' => $genero,
    'musicas' => $musicas
];

// remove vínculo
$conn->prepare("UPDATE musicas SET GeneroID = NULL WHERE GeneroID = ?")->execute([$id]);

$repo->deletar($id);

header("Location: listar.php?msg=excluido");