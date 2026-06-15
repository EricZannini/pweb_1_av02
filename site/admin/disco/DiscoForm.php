<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('discos');
$errors = [];
$data = null;

// novo ou edição
if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {
    // valida
    if (empty($_POST['titulo'])) $errors[] = '<li>Título é obrigatório.</li>';
    if (empty($_POST['artista'])) $errors[] = '<li>Artista é obrigatório.</li>';
    if (empty($_POST['genero'])) $errors[] = '<li>Gênero é obrigatório.</li>';
    if (empty($_POST['preco'])) $errors[] = '<li>Preço é obrigatório.</li>';
    if (empty($_POST['ano_lancamento'])) $errors[] = '<li>Ano é obrigatório.</li>';

    // salva ou atualiza
    if (empty($errors)) {
        try {
            if (empty($_POST['id'])) {
                $db->store($_POST);
            } else {
                $db->update($_POST);
            }
            redirect('/pweb_1_av02/site/admin/disco/DiscoList.php');
        } catch (Exception $e) {
            $errors[] = '<li>Erro ao salvar: ' . $e->getMessage() . '</li>';
        }
    }

    $data = (object) $_POST;
}
?>

<div class="glass-effect">
    <h4 class="fw-bold mb-4">
        <i class="fa-solid fa-record-vinyl me-2" style="color:#9b5de5"></i>
        <?= empty($_GET['id']) ? 'Novo Disco' : 'Editar Disco' ?>
    </h4>

    <?php showValidationError($errors); ?>

    <form method="POST">
        <?php // id escondido — define se vai cadastrar ou editar ?>
        <input type="hidden" name="id" value="<?= getFormValue($data, 'id') ?>">

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control"
                   value="<?= getFormValue($data, 'titulo') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Artista</label>
            <input type="text" name="artista" class="form-control"
                   value="<?= getFormValue($data, 'artista') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Gênero</label>
            <input type="text" name="genero" class="form-control"
                   value="<?= getFormValue($data, 'genero') ?>">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Preço (R$)</label>
                <input type="number" step="0.01" name="preco" class="form-control"
                       value="<?= getFormValue($data, 'preco') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Ano de Lançamento</label>
                <input type="number" name="ano_lancamento" class="form-control"
                       min="1900" max="2099"
                       value="<?= getFormValue($data, 'ano_lancamento') ?>">
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk me-1"></i>Salvar
            </button>
            <a href="DiscoList.php" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </form>
</div>

<?php include '../footer.php'; ?>
