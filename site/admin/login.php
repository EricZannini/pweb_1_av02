<?php
$paginaAuth = true;
include 'header.php';
include_once 'database/db.class.php';

$error = '';

// só processa se o formulário foi enviado
if (!empty($_POST)) {
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($login) || empty($senha)) {
        $error = 'Preencha todos os campos.';
    } else {
        // busca o usuário
        $db = new db('usuarios');
        $usuario = $db->findBy('login', $login);

        // checa a senha
        if ($usuario && password_verify($senha, $usuario->senha)) {
            // salva na sessão
            $_SESSION['usuario_id'] = $usuario->id;
            $_SESSION['usuario_nome'] = $usuario->nome;
            $_SESSION['usuario_email'] = $usuario->email;
            redirect('/pweb_1_av02/site/admin/index.php');
        } else {
            $error = 'Login ou senha inválidos.';
        }
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="glass-effect">
            <h4 class="text-center mb-4">
                <i class="fa-solid fa-record-vinyl me-2" style="color:#c5a059"></i>
                <strong><span style="color:#c5a059">Vinyl</span>Store</strong> Admin
            </h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Login</label>
                    <input type="text" name="login" class="form-control"
                           value="<?= $_POST['login'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <hr>
            <p class="text-center mb-0 small">
                Não tem conta?
                <a href="/pweb_1_av02/site/admin/registrar.php">Cadastre-se</a>
            </p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
