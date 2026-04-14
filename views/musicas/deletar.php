<?php
session_start();
require_once '../../repositories/MusicaRepository.php';

$repo = new MusicaRepository();

$id = $_GET['id'];
$musica = $repo->buscar($id);

$_SESSION['undo'] = [
    'tipo' => 'musica',
    'dados' => $musica
];

$repo->deletar($id);

header("Location: listar.php?msg=excluido");