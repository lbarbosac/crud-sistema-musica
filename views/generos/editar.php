<?php
require_once '../../repositories/GeneroRepository.php';
include '../layout/header.php';

$repo = new GeneroRepository();
$id = $_GET['id'];
$dado = $repo->buscar($id);

if($_POST){
    $repo->atualizar($id, $_POST['nome']);
    header("Location: listar.php");
}
?>

<div class="card">
    <h2>Editar Gênero</h2>

    <form method="POST">
        <input name="nome" value="<?= $dado['nome'] ?>" required>
        <button class="btn btn-primary">Atualizar</button>
    </form>
</div>

<?php include '../layout/footer.php'; ?>