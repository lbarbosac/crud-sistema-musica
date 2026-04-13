<?php
require_once '../../repositories/MusicaRepository.php';

$repo = new MusicaRepository();
$repo->deletar($_GET['id']);

header("Location: listar.php");