<?php
session_start();
require_once '../../repositories/MusicaRepository.php';
include '../layout/header.php';

$repo = new MusicaRepository();
$musicas = $repo->listar();
?>

<div class="card">

    <div class="top-bar">
        <h1>Lista de Músicas</h1>

        <div class="actions">
            <a href="../artistas/listar.php" class="btn btn-secondary">Artistas</a>
            <a href="../generos/listar.php" class="btn btn-secondary">Gêneros</a>
            <a href="criar.php" class="btn btn-primary">Nova Música</a>
        </div>
    </div>

    <?php if(isset($_GET['msg']) && isset($_SESSION['undo']) && $_SESSION['undo']['tipo'] == 'musica'): ?>
        <div class="alert alert-success">
            Música "<?= $_SESSION['undo']['dados']['titulo'] ?>" excluída
            <a href="desfazer.php" class="undo-link">Desfazer</a>
        </div>
    <?php endif; ?>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Artista</th>
                    <th>Gênero</th>
                    <th>Duração</th>
                    <th>Ano</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($musicas as $m): ?>
                <tr>
                    <td><?= $m['MusicaID'] ?></td>
                    <td><?= $m['titulo'] ?></td>
                    <td><?= $m['artista'] ?? 'Sem artista' ?></td>
                    <td><?= $m['genero'] ?? 'Sem gênero' ?></td>
                    <td><?= $m['duracao'] ?></td>
                    <td><?= $m['AnoLancamento'] ?></td>
                    <td>
                        <div class="actions">
                            <a href="editar.php?id=<?= $m['MusicaID'] ?>" class="btn btn-edit">Editar</a>

                            <a href="#" 
                               onclick="abrirModalMusica(<?= $m['MusicaID'] ?>); return false;" 
                               class="btn btn-delete">
                                Excluir
                            </a>

                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</div>

<div id="modal-musica" class="modal-warning">
    <div class="modal-warning-content">
        <p>Deseja realmente excluir esta música?</p>

        <div class="modal-warning-buttons">
            <button id="cancelar-musica" class="btn btn-secondary">
                Cancelar
            </button>

            <a id="confirmar-musica" class="btn btn-delete" href="#">
                Confirmar
            </a>
        </div>
    </div>
</div>

<script>
function abrirModalMusica(id) {

    if(localStorage.getItem("avisos") === "off"){
        window.location.href = "deletar.php?id=" + id;
        return;
    }

    const modal = document.getElementById("modal-musica");

    modal.classList.add("show");

    document.getElementById("confirmar-musica").href = "deletar.php?id=" + id;

    document.getElementById("cancelar-musica").onclick = function() {
        modal.classList.remove("show");
    };
}

window.addEventListener("click", function(e) {
    const modal = document.getElementById("modal-musica");
    if (e.target === modal) {
        modal.classList.remove("show");
    }
});
</script>

<?php include '../layout/footer.php'; ?>