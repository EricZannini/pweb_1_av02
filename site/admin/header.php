<?php

// evita abrir sessão duas vezes
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// redireciona com um pequeno delay (em ms)
function redirect($page, $time = 1500)
{
    echo "<script>setTimeout(() => { window.location.href = '$page'; }, $time);</script>";
}

// mostra mensagem de sucesso ou erro na tela
function actionMessage($success = '', $actionError = '')
{
    if (!empty($success)) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                $success
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
    if (!empty($actionError)) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                $actionError
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
}

// lista os erros de validação em formato de lista
function showValidationError($errors = [])
{
    if (!empty($errors)) {
        echo "<div class='alert alert-danger'><ul class='mb-0'>";
        foreach ($errors as $error) {
            echo $error;
        }
        echo "</ul></div>";
    }
}

// mantém o valor preenchido no input caso o formulário dê erro
function getFormValue($data, $field)
{
    if (is_object($data) && isset($data->$field)) {
        return htmlspecialchars($data->$field);
    }
    if (is_array($data) && isset($data[$field])) {
        return htmlspecialchars($data[$field]);
    }
    return '';
}
?>
<!doctype html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VinylStore Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- fonte do TAV01 -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Special+Elite&display=swap" rel="stylesheet">

    <style>
        /* inspiração para o CSS: https://pin.it/6VtQZIxjq */
        /* desenvolvedor: @lucaslab.dev */

        /* variáveis reutilizadas do TAV01 */
        :root {
            --gold: #c5a059;
            --dark-bg: #121212;
            --card-bg: #1e1e1e;
        }

        body {
            background-color: var(--dark-bg);
            background-image: url('https://www.transparenttextures.com/patterns/dark-matter.png');
            color: #d4d4d4;
            font-family: 'Special Elite', cursive;
        }

        h1, h2, h3, h4, h5, strong {
            font-family: 'Cinzel', serif;
            letter-spacing: 1px;
        }

        .glass-effect {
            background: #1a1a1a;
            border: 1px solid var(--gold);
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(197, 160, 89, 0.15);
            padding: 20px;
            margin-top: 20px;
        }

        /* hover nos cards — do TAV01 */
        a .glass-effect {
            transition: 0.4s;
        }
        a .glass-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 22px rgba(197, 160, 89, 0.35), 0 10px 20px rgba(0,0,0,0.5);
        }

        /* detalhe lateral dourado nas seções — do TAV01 */
        .glass-effect h4 {
            border-left: 4px solid var(--gold);
            padding-left: 12px;
        }

        .arredondado { border-radius: 32px; }

        .table { --bs-table-bg: transparent; }

        /* glow dourado nos cards — do TAV01 */
        a .glass-effect:hover {
            transform: translateY(-5px);
            border-color: var(--gold);
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

<div class="container">

    <?php // esconde o cabeçalho nas páginas de login e cadastro ?>
    <?php if (empty($paginaAuth)): ?>
    <header class="blog-header glass-effect">
        <div class="row d-flex justify-content align-items-center">

            <div class="col-4">
                <a class="link-secondary text-decoration-none" href="/pweb_1_av02/site/admin/index.php">
                    <i class="fa-solid fa-record-vinyl me-1" style="color:#c5a059"></i>
                    <strong><span style="color:#c5a059">Vinyl</span>Store</strong> Admin
                </a>
            </div>

            <div class="col-4 text-center">
                <?php if (isset($_SESSION['usuario_nome'])): ?>
                    <span class="text-white-50 small">
                        Olá, <?= $_SESSION['usuario_nome'] ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="col-4 text-end">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a class="btn btn-sm btn-outline-secondary glass-effect"
                       href="/pweb_1_av02/site/admin/logout.php">
                        <i class="fa-solid fa-right-from-bracket me-1"></i>Sair
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </header>
    <?php endif; ?>

    <?php // só mostra o menu se estiver logado ?>
    <?php if (isset($_SESSION['usuario_id'])): ?>
    <div class="nav-scroller py-1 mb-2">
        <nav class="nav flex justify-content-between">

            <a href="/pweb_1_av02/site/admin/index.php"
               class="btn glass-effect text-white">
                <i class="fa-solid fa-gauge-high me-1"></i>Dashboard
            </a>

            <a href="/pweb_1_av02/site/admin/disco/DiscoList.php"
               class="btn glass-effect text-white">
                <i class="fa-solid fa-record-vinyl me-1"></i>Discos
            </a>

            <a href="/pweb_1_av02/site/admin/artista/ArtistaList.php"
               class="btn glass-effect text-white">
                <i class="fa-solid fa-music me-1"></i>Artistas
            </a>

            <a href="/pweb_1_av02/site/admin/venda/VendaList.php"
               class="btn glass-effect text-white">
                <i class="fa-solid fa-cart-shopping me-1"></i>Vendas
            </a>

            <a href="/pweb_1_av02/site/admin/usuario/UsuarioList.php"
               class="btn glass-effect text-white">
                <i class="fa-solid fa-users me-1"></i>Usuários
            </a>

        </nav>
    </div>
    <?php endif; ?>

    <main>
