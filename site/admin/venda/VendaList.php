<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('vendas');

if (!empty($_GET['delete'])) {
    $db->destroy($_GET['delete']);
    $msgDelete = 'Venda excluída com sucesso!';
}

$vendas = $db->all();

if (isset($_POST['buscar'])) {
    $vendas = $db->search(['tipo' => $_POST['tipo'], 'valor' => $_POST['valor']]);
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-cart-shopping me-2" style="color:#c5a059"></i>Vendas</h4>
    <a href="VendaForm.php" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i>Nova Venda
    </a>
</div>

<?php if (!empty($msgDelete)): ?>
    <div class="alert alert-success"><?= $msgDelete ?></div>
<?php endif; ?>

<form method="POST" class="glass-effect p-3 mb-4 d-flex gap-2 flex-wrap">
    <select name="tipo" class="form-select" style="max-width:200px;">
        <option value="cliente_nome">Cliente</option>
        <option value="disco_titulo">Disco</option>
    </select>
    <input type="text" name="valor" class="form-control" style="max-width:260px;"
           placeholder="Pesquisar..."
           value="<?= $_POST['valor'] ?? '' ?>">
    <button type="submit" name="buscar" class="btn btn-outline-light">
        <i class="fa-solid fa-magnifying-glass me-1"></i>Buscar
    </button>
    <a href="VendaList.php" class="btn btn-outline-secondary">Limpar</a>
</form>

<div class="glass-effect p-0 overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Disco</th>
                <th>Qtd</th>
                <th>Total</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($vendas)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Nenhuma venda encontrada.</td></tr>
            <?php else: ?>
                <?php foreach ($vendas as $venda): ?>
                <tr>
                    <td class="text-muted small"><?= $venda->id ?></td>
                    <td><?= $venda->cliente_nome ?></td>
                    <td><?= $venda->disco_titulo ?></td>
                    <td><span class="badge bg-secondary"><?= $venda->quantidade ?></span></td>
                    <td>R$ <?= number_format($venda->valor_total, 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($venda->data_venda)) ?></td>
                    <td>
                        <a href="VendaForm.php?id=<?= $venda->id ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="?delete=<?= $venda->id ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Deseja excluir esta venda?')">
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
