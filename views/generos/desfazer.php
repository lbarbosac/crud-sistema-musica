<?php
session_start();
require_once '../../repositories/GeneroRepository.php';

if(isset($_SESSION['undo']) && $_SESSION['undo']['tipo'] == 'genero'){
    $repo = new GeneroRepository();
    $repo->criar($_SESSION['undo']['dados']['nome']);
    unset($_SESSION['undo']);
}

header("Location: listar.php");