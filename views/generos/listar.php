<?php
session_start();
require_once '../../repositories/GeneroRepository.php';
include '../layout/header.php';

$repo = new GeneroRepository();
$dados = $repo->listar();
?>

<div class="card">

    <div class="top-bar">
        <h2>Gêneros</h2>
        <a href="criar.php" class="btn btn-primary">Adicionar</a>
    </div>

    <?php if(isset($_GET['msg']) && isset($_SESSION['undo']) && $_SESSION['undo']['tipo'] == 'genero'): ?>
        <div class="alert alert-success">
            Gênero "<?= $_SESSION['undo']['dados']['nome'] ?>" excluído
            <a href="desfazer.php" class="undo-link">Desfazer</a>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['confirmar'])): ?>
        <div class="alert alert-error">
            O gênero selecionado está vinculado a <?= $_GET['qtd'] ?> música(s).<br>
            Ao continuar, essas músicas ficarão sem gênero associado.<br><br>
            Deseja realmente excluir este gênero?

            <br><br>

            <a href="deletar.php?id=<?= $_GET['id'] ?>&confirmado=1" class="btn btn-delete">
                Confirmar exclusão
            </a>
        </div>
    <?php endif; ?>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($dados as $d): ?>
                <tr>
                    <td><?= $d['GeneroID'] ?></td>
                    <td><?= $d['nome'] ?></td>
                    <td class="actions">
                        <a href="editar.php?id=<?= $d['GeneroID'] ?>" class="btn btn-edit">Editar</a>
                        <a href="#" onclick="confirmarExclusao('deletar.php?id=<?= $d['GeneroID'] ?>')" class="btn btn-delete">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</div>

<?php include '../layout/footer.php'; ?>