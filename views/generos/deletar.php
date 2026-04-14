<?php
require_once '../../repositories/GeneroRepository.php';

$repo = new GeneroRepository();

$sucesso = $repo->deletar($_GET['id']);

if(!$sucesso){
    header("Location: listar.php?erro=1");
} else {
    header("Location: listar.php?sucesso=1");
}