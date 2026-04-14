<?php
session_start();
require_once '../../repositories/ArtistaRepository.php';

if(isset($_SESSION['undo']) && $_SESSION['undo']['tipo'] == 'artista'){
    $repo = new ArtistaRepository();
    $repo->criar($_SESSION['undo']['dados']['nome']);
    unset($_SESSION['undo']);
}

header("Location: listar.php");