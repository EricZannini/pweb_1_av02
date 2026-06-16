<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('discos');

if (!empty($_GET['delete'])) {
    $db->destroy($_GET['delete']);
    $msgDelete = 'Disco excluído com sucesso!';
}

$discos = $db->all();

if (isset($_POST['buscar'])) {
    $discos = $db->search(['tipo' => $_POST['tipo'], 'valor' => $_POST['valor']]);
}

if (!empty($_GET['genero'])) {
    $discos = $db->search(['tipo' => 'genero', 'valor' => $_GET['genero']]);
}

$generos = [];
foreach ($db->all() as $d) {
    if (!in_array($d->genero, $generos)) $generos[] = $d->genero;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-record-vinyl me-2" style="color:#c5a059"></i>Discos</h4>
    <a href="DiscoForm.php" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i>Novo Disco
    </a>
</div>

<?php if (!empty($msgDelete)): ?>
    <div class="alert alert-success"><?= $msgDelete ?></div>
<?php endif; ?>

<?php if (!empty($generos)): ?>
<div class="mb-3 d-flex gap-2 flex-wrap">
    <a href="DiscoList.php" class="btn btn-sm btn-outline-secondary">Todos</a>
    <?php foreach ($generos as $g): ?>
        <a href="?genero=<?= urlencode($g) ?>"
           class="btn btn-sm <?= ($_GET['genero'] ?? '') === $g ? 'btn-secondary' : 'btn-outline-secondary' ?>">
            <?= $g ?>
        </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<form method="POST" class="glass-effect p-3 mb-4 d-flex gap-2 flex-wrap">
    <select name="tipo" class="form-select" style="max-width:180px;">
        <option value="titulo">Título</option>
        <option value="artista">Artista</option>
        <option value="genero">Gênero</option>
    </select>
    <input type="text" name="valor" class="form-control" style="max-width:260px;"
           placeholder="Pesquisar..."
           value="<?= $_POST['valor'] ?? '' ?>">
    <button type="submit" name="buscar" class="btn btn-outline-light">
        <i class="fa-solid fa-magnifying-glass me-1"></i>Buscar
    </button>
    <a href="DiscoList.php" class="btn btn-outline-secondary">Limpar</a>
</form>

<div class="glass-effect p-0 overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Artista</th>
                <th>Gênero</th>
                <th>Preço</th>
                <th>Ano</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($discos)): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">Nenhum disco encontrado.</td></tr>
            <?php else: ?>
                <?php foreach ($discos as $disco): ?>
                <tr>
                    <td class="text-muted small"><?= $disco->id ?></td>
                    <td><?= $disco->titulo ?></td>
                    <td><?= $disco->artista ?></td>
                    <td><?= $disco->genero ?></td>
                    <td>R$ <?= number_format($disco->preco, 2, ',', '.') ?></td>
                    <td><?= $disco->ano_lancamento ?></td>
                    <td>
                        <?php if ($disco->estoque > 0): ?>
                            <span class="badge" style="background:#2d6a2d"><?= $disco->estoque ?></span>
                        <?php else: ?>
                            <span class="badge bg-danger">0</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="DiscoForm.php?id=<?= $disco->id ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="?delete=<?= $disco->id ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Deseja excluir este disco?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>
