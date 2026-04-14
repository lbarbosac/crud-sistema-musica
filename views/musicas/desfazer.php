<?php
session_start();
require_once '../../repositories/MusicaRepository.php';

if(isset($_SESSION['undo']) && $_SESSION['undo']['tipo'] == 'musica'){
    $repo = new MusicaRepository();
    $dados = $_SESSION['undo']['dados'];

    $repo->criar($dados);

    unset($_SESSION['undo']);
}

header("Location: listar.php");