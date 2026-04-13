<?php
require_once '../../repositories/GeneroRepository.php';
$repo = new GeneroRepository();
$repo->deletar($_GET['id']);
header("Location: listar.php");