<?php
include '../header.php';
include '../autenticacao.php';
include_once '../database/db.class.php';

$db = new db('artistas');

// deleta
if (!empty($_GET['delete'])) {
    $db->destroy($_GET['delete']);
    $msgDelete = 'Artista excluído com sucesso!';
}

// pega tudo
$artistas = $db->all();

// pesquisa
if (isset($_POST['buscar'])) {
    $artistas = $db->search(['tipo' => $_POST['tipo'], 'valor' => $_POST['valor']]);
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-music me-2" style="color:#4895ef"></i>Artistas</h4>
    <a href="ArtistaForm.php" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i>Novo Artista
    </a>
</div>

<?php if (!empty($msgDelete)): ?>
    <div class="alert alert-success"><?= $msgDelete ?></div>
<?php endif; ?>

<form method="POST" class="glass-effect p-3 mb-4 d-flex gap-2 flex-wrap">
    <select name="tipo" class="form-select" style="max-width:180px;">
        <option value="nome">Nome</option>
        <option value="nacionalidade">Nacionalidade</option>
        <option value="estilo_musical">Estilo</option>
    </select>
    <input type="text" name="valor" class="form-control" style="max-width:260px;"
           placeholder="Pesquisar..."
           value="<?= $_POST['valor'] ?? '' ?>">
    <button type="submit" name="buscar" class="btn btn-outline-light">
        <i class="fa-solid fa-magnifying-glass me-1"></i>Buscar
    </button>
    <a href="ArtistaList.php" class="btn btn-outline-secondary">Limpar</a>
</form>

<div class="glass-effect p-0 overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Nacionalidade</th>
                <th>Estilo Musical</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($artistas)): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">Nenhum artista encontrado.</td></tr>
            <?php else: ?>
                <?php // mostra cada linha na tabela ?>
                <?php foreach ($artistas as $artista): ?>
                <tr>
                    <td class="text-muted small"><?= $artista->id ?></td>
                    <td><?= $artista->nome ?></td>
                    <td><?= $artista->nacionalidade ?></td>
                    <td><?= $artista->estilo_musical ?></td>
                    <td>
                        <a href="ArtistaForm.php?id=<?= $artista->id ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="?delete=<?= $artista->id ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Deseja excluir este artista?')">
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
