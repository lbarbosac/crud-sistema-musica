<?php
require_once '../../repositories/ArtistaRepository.php';
$repo = new ArtistaRepository();
$repo->deletar($_GET['id']);
header("Location: listar.php");