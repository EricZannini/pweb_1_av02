<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('usuarios');
$errors = [];
$data = null;
$editando = false;

// novo ou edição
if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
    $editando = true;
}

if (!empty($_POST)) {
    // valida
    if (empty($_POST['nome'])) $errors[] = '<li>Nome é obrigatório.</li>';
    if (empty($_POST['email'])) $errors[] = '<li>E-mail é obrigatório.</li>';
    if (empty($_POST['login'])) $errors[] = '<li>Login é obrigatório.</li>';
    if (!$editando && empty($_POST['senha'])) $errors[] = '<li>Senha é obrigatória.</li>';

    // salva com senha criptografada
    if (empty($errors)) {
        if (!$editando) {
            $_POST['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $db->store($_POST);
        } else {
            $dados = [
                'id' => $_POST['id'],
                'nome' => $_POST['nome'],
                'telefone' => $_POST['telefone'] ?? '',
                'email' => $_POST['email'],
                'login' => $_POST['login'],
            ];
            // edição: só atualiza a senha se preenchida
            if (!empty($_POST['senha'])) {
                $dados['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            }
            $db->update($dados);
        }
        redirect('/pweb_1_av02/site/admin/usuario/UsuarioList.php');
    }

    $data = (object) $_POST;
}
?>

<div class="glass-effect">
    <h4 class="fw-bold mb-4">
        <i class="fa-solid fa-users me-2"></i>
        <?= $editando ? 'Editar Usuário' : 'Novo Usuário' ?>
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
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control"
                   value="<?= getFormValue($data, 'telefone') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control"
                   value="<?= getFormValue($data, 'email') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Login</label>
            <input type="text" name="login" class="form-control"
                   value="<?= getFormValue($data, 'login') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Senha <?= $editando ? '(deixe em branco para não alterar)' : '' ?></label>
            <input type="password" name="senha" class="form-control">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk me-1"></i>Salvar
            </button>
            <a href="UsuarioList.php" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </form>
</div>

<?php include '../footer.php'; ?>
