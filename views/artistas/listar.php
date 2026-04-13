<?php
require_once '../../repositories/ArtistaRepository.php';
include '../layout/header.php';

$repo = new ArtistaRepository();
$dados = $repo->listar();
?>

<div class="card">
    <div class="top-bar">
        <h2>Artistas</h2>
        <a href="criar.php" class="btn btn-primary">Adicionar</a>
    </div>

    <table>
        <tr><th>ID</th><th>Nome</th><th>Ações</th></tr>

        <?php foreach($dados as $d): ?>
        <tr>
            <td><?= $d['ArtistaID'] ?></td>
            <td><?= $d['nome'] ?></td>
            <td class="actions">
                <a href="editar.php?id=<?= $d['ArtistaID'] ?>" class="btn btn-edit">Editar</a>
                <a href="#" onclick="confirmarExclusao('deletar.php?id=<?= $d['ArtistaID'] ?>')" class="btn btn-delete">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include '../layout/footer.php'; ?>