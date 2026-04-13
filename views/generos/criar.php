<?php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Músicas</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php
require_once '../../repositories/GeneroRepository.php';
include '../layout/header.php';

$repo = new GeneroRepository();

if($_POST){
    $repo->criar($_POST['nome']);
    header("Location: listar.php");
}
?>

<div class="card">
    <h2>Novo Gênero</h2>

    <form method="POST">
        <div class="input-group">
            <label>Nome</label>
            <input name="nome" required>
        </div>

        <button class="btn btn-primary">Salvar</button>
    </form>
</div>

<?php include '../layout/footer.php'; ?>