<?php
require_once '../../repositories/MusicaRepository.php';
require_once '../../repositories/ArtistaRepository.php';
require_once '../../repositories/GeneroRepository.php';
include '../layout/header.php';


$repo = new MusicaRepository();
$artistas = (new ArtistaRepository())->listar();
$generos = (new GeneroRepository())->listar();


$erro = "";


if ($_POST) {
    $anoAtual = date("Y");

    if ($_POST['AnoLancamento'] > $anoAtual) {
        $erro = "Ano inválido!";
    } elseif (strlen(str_replace(':', '', $_POST['duracao'])) != 6) {
        $erro = "Duração inválida!";
    } else {
        $repo->criar($_POST);
        header("Location: listar.php");
        exit;
    }
}
?>


<div class="card">
    <h2>Nova Música</h2>

    <?php if ($erro): ?>
        <div class="alert alert-error"><?= $erro ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="input-group">
            <label>Título</label>
            <input name="titulo" required>
        </div>

        <div class="input-group">
            <label>Duração</label>
            <input name="duracao" placeholder="00:00:00" required>
        </div>

        <div class="input-group">
            <label>Ano</label>
            <input type="number" name="AnoLancamento" max="<?= date('Y') ?>" required>
        </div>

        <div class="input-group">
            <label>Artista</label>
            <select name="ArtistaID">
                <option value="">Sem artista</option>
                <?php foreach ($artistas as $a): ?>
                    <option value="<?= $a['ArtistaID'] ?>">
                        <?= $a['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="input-group">
            <label>Gênero</label>
            <select name="GeneroID">
                <option value="">Sem gênero</option>
                <?php foreach ($generos as $g): ?>
                    <option value="<?= $g['GeneroID'] ?>">
                        <?= $g['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-primary">Salvar</button>

    </form>
</div>

<?php include '../layout/footer.php'; ?>