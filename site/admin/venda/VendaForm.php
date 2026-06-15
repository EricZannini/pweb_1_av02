<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('vendas');
$errors = [];
$data = null;

// novo ou edição
if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {
    // valida
    if (empty($_POST['cliente_nome'])) $errors[] = '<li>Nome do cliente é obrigatório.</li>';
    if (empty($_POST['disco_titulo'])) $errors[] = '<li>Título do disco é obrigatório.</li>';
    if (empty($_POST['quantidade'])) $errors[] = '<li>Quantidade é obrigatória.</li>';
    if (empty($_POST['data_venda'])) $errors[] = '<li>Data é obrigatória.</li>';

    // salva ou atualiza
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
        <i class="fa-solid fa-cart-shopping me-2" style="color:#4cc9f0"></i>
        <?= empty($_GET['id']) ? 'Nova Venda' : 'Editar Venda' ?>
    </h4>

    <?php showValidationError($errors); ?>

    <form method="POST">
        <?php // id escondido — define se vai cadastrar ou editar ?>
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
            <div class="col-md-6 mb-3">
                <label class="form-label">Quantidade</label>
                <input type="number" name="quantidade" class="form-control" min="1"
                       value="<?= getFormValue($data, 'quantidade') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Data da Venda</label>
                <input type="date" name="data_venda" class="form-control"
                       value="<?= getFormValue($data, 'data_venda') ?>">
            </div>
        </div>

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
