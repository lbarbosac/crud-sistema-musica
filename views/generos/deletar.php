<?php
session_start();
require_once '../../repositories/GeneroRepository.php';

$repo = new GeneroRepository();

$id = $_GET['id'];
$dado = $repo->buscar($id);

$_SESSION['undo'] = [
    'tipo' => 'genero',
    'dados' => $dado
];

$repo->deletar($id);

header("Location: listar.php?msg=excluido");