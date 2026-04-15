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
                    $qtd = $repo->contarMusicas($d['GeneroID']);
                ?>
                <tr>
                    <td><?= $d['GeneroID'] ?></td>
                    <td><?= $d['nome'] ?></td>
                    <td class="actions">

                        <a href="editar.php?id=<?= $d['GeneroID'] ?>" class="btn btn-edit">
                            Editar
                        </a>

                        <?php if($qtd > 0): ?>
                            <a href="#" 
                               onclick="abrirModalGenero(<?= $d['GeneroID'] ?>, <?= $qtd ?>)" 
                               class="btn btn-delete">
                                Excluir
                            </a>
                        <?php else: ?>
                            <a href="#" 
                               onclick="confirmarExclusaoDireta('deletar.php?id=<?= $d['GeneroID'] ?>')" 
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

<div id="modal-genero" class="modal-warning">
    <div class="modal-warning-content">
        <p id="texto-modal"></p>

        <div class="modal-warning-buttons">
            <button id="cancelar-genero" class="btn btn-secondary">
                Cancelar
            </button>

            <button id="confirmar-genero" class="btn btn-delete">
                Confirmar
            </button>
        </div>
    </div>
</div>

<script>
function confirmarExclusaoDireta(url){
    if(localStorage.getItem("avisos") === "off"){
        window.location.href = url;
    } else {
        if(confirm("Deseja realmente excluir?")){
            window.location.href = url;
        }
    }
}

function abrirModalGenero(id, qtd) {

    if(localStorage.getItem("avisos") === "off"){
        window.location.href = "deletar.php?id=" + id;
        return;
    }

    const modal = document.getElementById("modal-genero");
    const texto = document.getElementById("texto-modal");

    texto.innerHTML = `
        Este gênero está vinculado a ${qtd} música(s).<br>
        Ao continuar, essas músicas ficarão sem gênero associado.<br><br>
        Deseja realmente excluir este gênero?
    `;

    modal.classList.add("show");

    document.getElementById("confirmar-genero").onclick = function() {
        window.location.href = "deletar.php?id=" + id;
    };

    document.getElementById("cancelar-genero").onclick = function() {
        modal.classList.remove("show");
    };
}

window.onclick = function(e) {
    const modal = document.getElementById("modal-genero");
    if (e.target === modal) {
        modal.classList.remove("show");
    }
};
</script>

<?php include '../layout/footer.php'; ?>