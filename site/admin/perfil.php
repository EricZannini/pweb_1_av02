<?php
include 'header.php';
include 'autenticacao.php';
include_once 'database/db.class.php';

$db = new db('usuarios');
$errors = [];
$success = '';

$usuario = $db->find($_SESSION['usuario_id']);

if (!empty($_POST)) {
    if (empty($_POST['nome'])) $errors[] = '<li>Nome é obrigatório.</li>';
    if (empty($_POST['email'])) $errors[] = '<li>E-mail é obrigatório.</li>';

    if (empty($errors)) {
        $dados = [
            'id' => $_SESSION['usuario_id'],
            'nome' => $_POST['nome'],
            'telefone' => $_POST['telefone'] ?? '',
            'email' => $_POST['email'],
            'login' => $usuario->login,
        ];

        if (!empty($_POST['senha'])) {
            $dados['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        }

        $db->update($dados);
        $_SESSION['usuario_nome'] = $_POST['nome'];
        $success = 'Perfil atualizado com sucesso!';
        $usuario = $db->find($_SESSION['usuario_id']);
    }
}
?>

<div class="glass-effect">
    <h4 class="fw-bold mb-4">
        <i class="fa-solid fa-circle-user me-2" style="color:#c5a059"></i>Meu Perfil
    </h4>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <?php showValidationError($errors); ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control"
                   value="<?= $usuario->nome ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control"
                   value="<?= $usuario->telefone ?? '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control"
                   value="<?= $usuario->email ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Login</label>
            <input type="text" class="form-control" value="<?= $usuario->login ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Nova Senha <small class="text-muted">(deixe em branco para não alterar)</small></label>
            <input type="password" name="senha" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk me-1"></i>Salvar
        </button>
    </form>
</div>

<?php include 'footer.php'; ?>
