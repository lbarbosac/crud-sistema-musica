<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Músicas</title>

    <link rel="stylesheet" href="/sisteamas-musicas/assets/css/style.css">
</head>
<body>

<div class="container">

    <div class="header">
        <div class="top-bar">
            <h1>Sistema de Músicas</h1>

            <div class="actions">
                <a href="/sisteamas-musicas/views/musicas/listar.php" class="btn btn-secondary">Músicas</a>
                <a href="/sisteamas-musicas/views/artistas/listar.php" class="btn btn-secondary">Artistas</a>
                <a href="/sisteamas-musicas/views/generos/listar.php" class="btn btn-secondary">Gêneros</a>
            </div>
        </div>
    </div>