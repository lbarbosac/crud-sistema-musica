<?php
session_start();
require_once '../../repositories/GeneroRepository.php';

$repo = new GeneroRepository();

$id = $_GET['id'];
$genero = $repo->buscar($id);

$qtd = $repo->contarMusicas($id);

if($qtd > 0 && !isset($_GET['confirmado'])) {
    header("Location: listar.php?confirmar=1&id=$id&qtd=$qtd");
    exit;
}

$_SESSION['undo'] = [
    'tipo' => 'genero',
    'dados' => $genero
];

if($qtd > 0){
    $repo->removerVinculoMusicas($id);
}

$repo->deletar($id);

header("Location: listar.php?msg=excluido");