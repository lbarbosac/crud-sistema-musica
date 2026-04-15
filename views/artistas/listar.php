<?php
session_start();
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

    <?php if(isset($_GET['msg']) && isset($_SESSION['undo']) && $_SESSION['undo']['tipo'] == 'artista'): ?>
        <div class="alert alert-success">
            Artista "<?= $_SESSION['undo']['dados']['nome'] ?>" excluído
            <a href="desfazer.php" class="undo-link">Desfazer</a>
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
                <?php foreach($dados as $d): 
                    $qtd = $repo->contarMusicas($d['ArtistaID']);
                ?>
                <tr>
                    <td><?= $d['ArtistaID'] ?></td>
                    <td><?= $d['nome'] ?></td>
                    <td class="actions">

                        <a href="editar.php?id=<?= $d['ArtistaID'] ?>" class="btn btn-edit">
                            Editar
                        </a>

                        <?php if($qtd > 0): ?>
                            <a href="#" 
                               onclick="abrirModalArtista(<?= $d['ArtistaID'] ?>, <?= $qtd ?>)" 
                               class="btn btn-delete">
                                Excluir
                            </a>
                        <?php else: ?>
                            <a href="#" 
                               onclick="confirmarExclusao('deletar.php?id=<?= $d['ArtistaID'] ?>')" 
                               class="btn btn-delete">
                                Excluir
                            </a>
                        <?php endif; ?>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<div id="modal-artista" class="modal-warning">
    <div class="modal-warning-content">
        <p id="texto-modal-artista"></p>

        <div class="modal-warning-buttons">
            <button id="cancelar-artista" class="btn btn-secondary">
                Cancelar
            </button>

            <button id="confirmar-artista" class="btn btn-delete">
                Confirmar
            </button>
        </div>
    </div>
</div>

<script>
function abrirModalArtista(id, qtd) {
    const modal = document.getElementById("modal-artista");
    const texto = document.getElementById("texto-modal-artista");

    texto.innerHTML = `
        Este artista está vinculado a ${qtd} música(s).<br>
        Ao continuar, essas músicas ficarão sem artista associado.<br><br>
        Deseja realmente excluir este artista?
    `;

    modal.classList.add("show");

    document.getElementById("confirmar-artista").onclick = function() {
        window.location.href = "deletar.php?id=" + id;
    };

    document.getElementById("cancelar-artista").onclick = function() {
        modal.classList.remove("show");
    };
}

// fechar clicando fora
window.onclick = function(e) {
    const modal = document.getElementById("modal-artista");
    if (e.target === modal) {
        modal.classList.remove("show");
    }
};
</script>

<?php include '../layout/footer.php'; ?>