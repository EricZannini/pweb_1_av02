<?php
$paginaAuth = true;
include 'header.php';
include_once 'database/db.class.php';

$errors = [];
$success = '';

if (!empty($_POST)) {
    if (empty($_POST['nome'])) $errors[] = '<li>Nome é obrigatório.</li>';
    if (empty($_POST['email'])) $errors[] = '<li>E-mail é obrigatório.</li>';
    if (empty($_POST['login'])) $errors[] = '<li>Login é obrigatório.</li>';
    if (empty($_POST['senha'])) $errors[] = '<li>Senha é obrigatória.</li>';

    if (empty($errors)) {
        $db = new db('usuarios');

        // verifica se o login já existe
        $existe = $db->findBy('login', $_POST['login']);
        if ($existe) {
            $errors[] = '<li>Este login já está em uso.</li>';
        } else {
            // criptografa e salva
            $db->store([
                'nome' => $_POST['nome'],
                'telefone' => $_POST['telefone'] ?? '',
                'email' => $_POST['email'],
                'login' => $_POST['login'],
                'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
            ]);
            $success = 'Cadastro realizado! Você já pode fazer login.';
        }
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="glass-effect">
            <h4 class="text-center mb-4">Criar Conta</h4>

            <?php showValidationError($errors); ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control"
                           value="<?= $_POST['nome'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-control"
                           value="<?= $_POST['telefone'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= $_POST['email'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Login</label>
                    <input type="text" name="login" class="form-control"
                           value="<?= $_POST['login'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
            </form>

            <hr>
            <p class="text-center mb-0 small">
                Já tem conta? <a href="/pweb_1_av02/site/admin/login.php">Fazer login</a>
            </p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
