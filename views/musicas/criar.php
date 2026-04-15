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
    } else {
        // Processa a duração de forma flexível
        $raw = trim($_POST['duracao'] ?? '');
        $parts = array_filter(explode(':', $raw)); // remove vazios

        $h = 0;
        $m = 0;
        $s = 0;

        if (count($parts) === 2) {
            // 3:45 → 00:03:45
            $m = (int)$parts[0];
            $s = (int)$parts[1];
        } elseif (count($parts) === 3) {
            // 00:00:00
            $h = (int)$parts[0];
            $m = (int)$parts[1];
            $s = (int)$parts[2];
        } else {
            // Se não bate com nada, interpreta como segundos totais
            $seconds = (int)$raw;

            $h = (int)($seconds / 3600);
            $seconds %= 3600;
            $m = (int)($seconds / 60);
            $s = $seconds % 60;
        }

        // Valida limites (minutos e segundos de 0 a 59)
        if ($m > 59 || $s > 59 || $h < 0 || $m < 0 || $s < 0) {
            $erro = "Duração inválida! Use 00:00 ou 00:00:00.";
        } else {
            // Formata sempre como 00:00:00 para o banco
            $duracaoPadronizada = sprintf('%02d:%02d:%02d', $h, $m, $s);
            $_POST['duracao'] = $duracaoPadronizada;

            $repo->criar($_POST);
            header("Location: listar.php");
            exit;
        }
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
            <input name="duracao" placeholder="00:00 ou 00:00:00" required>
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