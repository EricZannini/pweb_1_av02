<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('artistas');
$errors = [];
$data = null;

// novo ou edição
if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {
    // valida
    if (empty($_POST['nome'])) $errors[] = '<li>Nome é obrigatório.</li>';
    if (empty($_POST['nacionalidade'])) $errors[] = '<li>Nacionalidade é obrigatória.</li>';
    if (empty($_POST['estilo_musical'])) $errors[] = '<li>Estilo musical é obrigatório.</li>';

    // salva ou atualiza
    if (empty($errors)) {
        try {
            if (empty($_POST['id'])) {
                $db->store($_POST);
            } else {
                $db->update($_POST);
            }
            redirect('/pweb_1_av02/site/admin/artista/ArtistaList.php');
        } catch (Exception $e) {
            $errors[] = '<li>Erro ao salvar: ' . $e->getMessage() . '</li>';
        }
    }

    $data = (object) $_POST;
}
?>

<div class="glass-effect">
    <h4 class="fw-bold mb-4">
        <i class="fa-solid fa-music me-2" style="color:#4895ef"></i>
        <?= empty($_GET['id']) ? 'Novo Artista' : 'Editar Artista' ?>
    </h4>

    <?php showValidationError($errors); ?>

    <form method="POST">
        <?php // id escondido — define se vai cadastrar ou editar ?>
        <input type="hidden" name="id" value="<?= getFormValue($data, 'id') ?>">

        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control"
                   value="<?= getFormValue($data, 'nome') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nacionalidade</label>
            <input type="text" name="nacionalidade" class="form-control"
                   value="<?= getFormValue($data, 'nacionalidade') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Estilo Musical</label>
            <input type="text" name="estilo_musical" class="form-control"
                   value="<?= getFormValue($data, 'estilo_musical') ?>">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk me-1"></i>Salvar
            </button>
            <a href="ArtistaList.php" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </form>
</div>

<?php include '../footer.php'; ?>
