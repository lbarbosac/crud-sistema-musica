<?php
session_start();
require_once '../../repositories/ArtistaRepository.php';

$repo = new ArtistaRepository();

$id = $_GET['id'];
$dado = $repo->buscar($id);

$_SESSION['undo'] = [
    'tipo' => 'artista',
    'dados' => $dado
];

$repo->deletar($id);

header("Location: listar.php?msg=excluido");