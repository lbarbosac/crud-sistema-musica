<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: /aula0414teste/auth/login.php");
    exit;
}