<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('usuarios');

// deleta
if (!empty($_GET['delete'])) {
    $db->destroy($_GET['delete']);
    $msgDelete = 'Usuário excluído com sucesso!';
}

// pega tudo
$usuarios = $db->all();

// pesquisa
if (isset($_POST['buscar'])) {
    $usuarios = $db->search(['tipo' => $_POST['tipo'], 'valor' => $_POST['valor']]);
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-users me-2"></i>Usuários</h4>
    <a href="UsuarioForm.php" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i>Novo Usuário
    </a>
</div>

<?php if (!empty($msgDelete)): ?>
    <div class="alert alert-success"><?= $msgDelete ?></div>
<?php endif; ?>

<form method="POST" class="glass-effect p-3 mb-4 d-flex gap-2 flex-wrap">
    <select name="tipo" class="form-select" style="max-width:180px;">
        <option value="nome">Nome</option>
        <option value="email">E-mail</option>
        <option value="login">Login</option>
    </select>
    <input type="text" name="valor" class="form-control" style="max-width:260px;"
           placeholder="Pesquisar..."
           value="<?= $_POST['valor'] ?? '' ?>">
    <button type="submit" name="buscar" class="btn btn-outline-light">
        <i class="fa-solid fa-magnifying-glass me-1"></i>Buscar
    </button>
    <a href="UsuarioList.php" class="btn btn-outline-secondary">Limpar</a>
</form>

<div class="glass-effect p-0 overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Login</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuarios)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Nenhum usuário encontrado.</td></tr>
            <?php else: ?>
                <?php // mostra cada linha na tabela ?>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td class="text-muted small"><?= $usuario->id ?></td>
                    <td><?= $usuario->nome ?></td>
                    <td><?= $usuario->email ?></td>
                    <td><?= $usuario->telefone ?? '' ?></td>
                    <td><code><?= $usuario->login ?></code></td>
                    <td>
                        <a href="UsuarioForm.php?id=<?= $usuario->id ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="?delete=<?= $usuario->id ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Deseja excluir este usuário?')">
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
