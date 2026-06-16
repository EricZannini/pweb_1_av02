<?php
$paginaAuth = true;
include 'header.php';
include_once 'database/db.class.php';

$error = '';

if (!empty($_POST)) {
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($login) || empty($senha)) {
        $error = 'Preencha todos os campos.';
    } else {
        $db = new db('usuarios');
        $usuario = $db->findBy('login', $login);

        if ($usuario && password_verify($senha, $usuario->senha)) {
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

<!-- animação uiverse.io/TheAbieza -->
<style>
@keyframes vinyl-spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(359deg); }
}
.vinyl-container {
    width: 175px;
    height: 175px;
    background-color: #1e1e1e;
    border-radius: 10px;
    position: relative;
    box-shadow: 5px 5px 0 0 #5a0000;
    display: flex;
    align-items: center;
    justify-content: center;
}
.plate { width: fit-content; }
.plate .vblack,
.plate .vwhite,
.plate .vcenter,
.plate .vborder { border-radius: 100%; }
.plate .vblack,
.plate .vwhite,
.plate .vborder {
    display: flex;
    align-items: center;
    justify-content: center;
}
.plate .vblack {
    width: 150px;
    height: 150px;
    background-color: #111;
    animation-name: vinyl-spin;
    animation-duration: 2s;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
}
.plate .vwhite {
    width: 70px;
    height: 70px;
    background-color: #c5a059;
}
.plate .vcenter {
    width: 20px;
    height: 20px;
    background-color: #111;
}
.plate .vborder {
    width: 111px;
    height: 111px;
    border-top: 3px solid #c5a059;
    border-bottom: 3px solid #c5a059;
    border-left: 3px solid #111;
    border-right: 3px solid #111;
}
.vplayer {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    width: fit-content;
    position: absolute;
    bottom: 0;
    right: 0;
    margin-bottom: 8px;
    margin-right: 8px;
    rotate: -45deg;
}
.vplayer .vcirc {
    width: 25px;
    height: 25px;
    background-color: #c5a059;
    border-radius: 100%;
    z-index: 1;
}
.vplayer .vrect {
    width: 10px;
    height: 55px;
    background-color: #c5a059;
    position: absolute;
    bottom: 0;
    margin-bottom: 5px;
}
</style>
<div class="d-flex justify-content-center mt-4">
    <div class="vinyl-container">
        <div class="plate">
            <div class="vblack">
                <div class="vborder">
                    <div class="vwhite">
                        <div class="vcenter"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vplayer">
            <div class="vcirc"></div>
            <div class="vrect"></div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
