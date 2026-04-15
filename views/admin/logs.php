<?php
require_once '../auth/guard.php';

if($_SESSION['user']['perfil'] != 'admin'){
    die("Acesso negado");
}

require_once '../repositories/LogRepository.php';

$logs = (new LogRepository())->listar();
?>

<table>
<?php foreach($logs as $l): ?>
<tr>
<td><?= $l['nome'] ?></td>
<td><?= $l['acao'] ?></td>
<td><?= $l['tabela'] ?></td>
<td><?= $l['criado_em'] ?></td>
</tr>
<?php endforeach; ?>
</table>