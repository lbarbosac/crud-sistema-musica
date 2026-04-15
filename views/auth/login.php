<?php
session_start();
require_once '../configs/database.php';

$erro = "";

if($_POST){
    $db = (new Database())->connect();

    $stmt = $db->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$_POST['username']]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($_POST['senha'], $user['senha'])){

        if($user['status'] != 'ativo'){
            $erro = "Usuário inativo";
        } else {
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'id' => $user['UsuarioID'],
                'nome' => $user['nome'],
                'perfil' => $user['perfil']
            ];

            $db->prepare("UPDATE usuarios SET ultimo_acesso = NOW() WHERE UsuarioID = ?")
               ->execute([$user['UsuarioID']]);

            header("Location: ../views/musicas/listar.php");
        }

    } else {
        $erro = "Login inválido";
    }
}
?>

<form method="POST">
    <input name="username" placeholder="Usuário" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button>Entrar</button>

    <?= $erro ?>
</form>