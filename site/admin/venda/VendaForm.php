<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('vendas');
$errors = [];
$data = null;

if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {
    if (empty($_POST['cliente_nome'])) $errors[] = '<li>Nome do cliente é obrigatório.</li>';
    if (empty($_POST['disco_titulo'])) $errors[] = '<li>Título do disco é obrigatório.</li>';
    if (empty($_POST['quantidade'])) $errors[] = '<li>Quantidade é obrigatória.</li>';
    if (empty($_POST['data_venda'])) $errors[] = '<li>Data é obrigatória.</li>';

    if (empty($errors)) {
        try {
            if (empty($_POST['id'])) {
                $db->store($_POST);
            } else {
                $db->update($_POST);
            }
            redirect('/pweb_1_av02/site/admin/venda/VendaList.php');
        } catch (Exception $e) {
            $errors[] = '<li>Erro ao salvar: ' . $e->getMessage() . '</li>';
        }
    }

    $data = (object) $_POST;
}
?>

<div class="glass-effect">
    <h4 class="fw-bold mb-4">
        <i class="fa-solid fa-cart-shopping me-2" style="color:#c5a059"></i>
        <?= empty($_GET['id']) ? 'Nova Venda' : 'Editar Venda' ?>
    </h4>

    <?php showValidationError($errors); ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= getFormValue($data, 'id') ?>">

        <div class="mb-3">
            <label class="form-label">Nome do Cliente</label>
            <input type="text" name="cliente_nome" class="form-control"
                   value="<?= getFormValue($data, 'cliente_nome') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Título do Disco</label>
            <input type="text" name="disco_titulo" class="form-control"
                   value="<?= getFormValue($data, 'disco_titulo') ?>">
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Quantidade</label>
                <input type="number" name="quantidade" id="quantidade" class="form-control" min="1"
                       value="<?= getFormValue($data, 'quantidade') ?>" onchange="calcTotal()">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Preço Unitário (R$)</label>
                <input type="number" name="preco_unitario" id="preco_unitario" step="0.01" class="form-control"
                       value="<?= getFormValue($data, 'preco_unitario') ?>" onchange="calcTotal()">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Total</label>
                <input type="number" name="valor_total" id="valor_total" step="0.01" class="form-control"
                       value="<?= getFormValue($data, 'valor_total') ?>" readonly>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Data da Venda</label>
            <input type="date" name="data_venda" class="form-control"
                   value="<?= getFormValue($data, 'data_venda') ?>">
        </div>

        <script>
        function calcTotal() {
            var qtd = document.getElementById('quantidade').value;
            var preco = document.getElementById('preco_unitario').value;
            if (qtd && preco) {
                document.getElementById('valor_total').value = (qtd * preco).toFixed(2);
            }
        }
        </script>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk me-1"></i>Salvar
            </button>
            <a href="VendaList.php" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </form>
</div>

<?php include '../footer.php'; ?>
