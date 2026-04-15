<?php
session_start();
require_once '../../repositories/ArtistaRepository.php';
require_once '../../configs/database.php';

$conn = (new Database())->connect();
$repo = new ArtistaRepository();

$id = $_GET['id'];

// artista
$artista = $repo->buscar($id);

// músicas que usam esse artista
$stmt = $conn->prepare("SELECT MusicaID FROM musicas WHERE ArtistaID = ?");
$stmt->execute([$id]);
$musicas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// salva tudo
$_SESSION['undo'] = [
    'tipo' => 'artista',
    'dados' => $artista,
    'musicas' => $musicas
];

// remove vínculo antes de excluir
$conn->prepare("UPDATE musicas SET ArtistaID = NULL WHERE ArtistaID = ?")->execute([$id]);

$repo->deletar($id);

header("Location: listar.php?msg=excluido");