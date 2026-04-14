<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Músicas</title>

    <link rel="stylesheet" href="/aula0414teste/assets/css/style.css">
</head>
<body>

<div class="container">

    <div class="header">
        <div class="top-bar">

            <h1>
                <a href="/aula0414teste/views/musicas/listar.php" style="text-decoration: none; color: inherit;">
                    Sistema de Músicas
                </a>
            </h1>

        </div>
    </div>