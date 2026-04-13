<?php
include '../layout/header.php';

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

require_once '../../repositories/MusicaRepository.php';
require_once '../../repositories/ArtistaRepository.php';
require_once '../../repositories/GeneroRepository.php';

$repo = new MusicaRepository();

$id = $_GET['id'];
$musica = $repo->buscar($id);

$artistas = (new ArtistaRepository())->listar();
$generos = (new GeneroRepository())->listar();

if($_POST) {
    $_POST['MusicaID'] = $id;
    $repo->atualizar($_POST);
    header("Location: listar.php");
}
?>

<form method="POST">
    <input name="titulo" value="<?= $musica['titulo'] ?>"><br>
    <input name="duracao" value="<?= $musica['duracao'] ?>"><br>
    <input name="AnoLancamento" value="<?= $musica['AnoLancamento'] ?>"><br>

    <select name="ArtistaID">
        <?php foreach($artistas as $a): ?>
            <option value="<?= $a['ArtistaID'] ?>"
                <?= $a['ArtistaID'] == $musica['ArtistaID'] ? 'selected' : '' ?>>
                <?= $a['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="GeneroID">
        <?php foreach($generos as $g): ?>
            <option value="<?= $g['GeneroID'] ?>"
                <?= $g['GeneroID'] == $musica['GeneroID'] ? 'selected' : '' ?>>
                <?= $g['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button>Atualizar</button>
</form>