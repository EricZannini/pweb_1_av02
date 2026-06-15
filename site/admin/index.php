<?php
include 'header.php';
include 'autenticacao.php';
include_once 'database/db.class.php';

// conta para mostrar nos cards
$totalDiscos = count((new db('discos'))->all());
$totalArtistas = count((new db('artistas'))->all());
$totalVendas = count((new db('vendas'))->all());
$totalUsuarios = count((new db('usuarios'))->all());
?>

<div class="glass-effect">
    <h4 class="fw-bold mb-1">
        <i class="fa-solid fa-gauge-high me-2"></i>Dashboard
    </h4>
    <p class="text-white-50 mb-4">Bem-vindo, <?= $_SESSION['usuario_nome'] ?>!</p>

    <div class="row g-3">
        <div class="col-md-3">
            <a href="/pweb_1_av02/site/admin/disco/DiscoList.php" class="text-decoration-none">
                <div class="glass-effect text-center">
                    <i class="fa-solid fa-record-vinyl fa-2x mb-2" style="color:#9b5de5"></i>
                    <h2 class="fw-bold"><?= $totalDiscos ?></h2>
                    <p class="text-white-50 mb-0">Discos</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="/pweb_1_av02/site/admin/artista/ArtistaList.php" class="text-decoration-none">
                <div class="glass-effect text-center">
                    <i class="fa-solid fa-music fa-2x mb-2" style="color:#4895ef"></i>
                    <h2 class="fw-bold"><?= $totalArtistas ?></h2>
                    <p class="text-white-50 mb-0">Artistas</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="/pweb_1_av02/site/admin/venda/VendaList.php" class="text-decoration-none">
                <div class="glass-effect text-center">
                    <i class="fa-solid fa-cart-shopping fa-2x mb-2" style="color:#4cc9f0"></i>
                    <h2 class="fw-bold"><?= $totalVendas ?></h2>
                    <p class="text-white-50 mb-0">Vendas</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="/pweb_1_av02/site/admin/usuario/UsuarioList.php" class="text-decoration-none">
                <div class="glass-effect text-center">
                    <i class="fa-solid fa-users fa-2x mb-2" style="color:#f8961e"></i>
                    <h2 class="fw-bold"><?= $totalUsuarios ?></h2>
                    <p class="text-white-50 mb-0">Usuários</p>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
