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

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Special+Elite&display=swap" rel="stylesheet">

    <style>
        :root {
            --gothic-red: #5a0000;
            --gothic-gold: #c5a059;
            --dark-bg: #121212;
            --card-bg: #1e1e1e;
        }

        body {
            background-color: var(--dark-bg);
            background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('/pweb_1_av02/site/admin/background_vinyl.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #d4d4d4;
            font-family: 'Special Elite', cursive;
        }

        h1, h2, h3, h4, h5, strong {
            font-family: 'Cinzel', serif;
            letter-spacing: 1px;
        }

        .glass-effect {
            background-color: var(--card-bg);
            border: 1px solid #333;
            border-left: 4px solid var(--gothic-red);
            padding: 20px;
            margin-top: 20px;
            transition: 0.4s;
        }

        a .glass-effect:hover {
            transform: translateY(-5px);
            border-left-color: var(--gothic-gold);
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }

        .glass-effect h4 {
            border-left: 5px solid var(--gothic-red);
            padding-left: 12px;
        }

        header { border-bottom: 2px solid var(--gothic-gold); }
        footer { border-top: 2px solid var(--gothic-gold); margin-top: 1rem; }

        .nav-scroller .nav a {
            color: #d4d4d4;
            text-decoration: none;
            font-family: 'Cinzel', serif;
            font-size: 13px;
            letter-spacing: 1px;
            padding-bottom: 4px;
            border-bottom: 2px solid transparent;
            transition: 0.3s;
        }

        .nav-scroller .nav a:hover {
            color: var(--gothic-gold);
            border-bottom-color: var(--gothic-gold);
        }

        .table { --bs-table-bg: transparent; }
    </style>
</head>
<body>

<div class="container">

    <?php // esconde o cabeçalho nas páginas de login e cadastro ?>
    <?php if (empty($paginaAuth)): ?>
    <header class="py-3">
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
                        Olá, <a href="/pweb_1_av02/site/admin/perfil.php" style="color:#c5a059; text-decoration:none;"><?= $_SESSION['usuario_nome'] ?></a>
                    </span>
                <?php endif; ?>
            </div>

            <div class="col-4 text-end">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a class="btn btn-sm btn-outline-secondary"
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

            <a href="/pweb_1_av02/site/admin/index.php">
                <i class="fa-solid fa-compact-disc me-1"></i>Dashboard
            </a>

            <a href="/pweb_1_av02/site/admin/disco/DiscoList.php">
                <i class="fa-solid fa-record-vinyl me-1"></i>Discos
            </a>

            <a href="/pweb_1_av02/site/admin/artista/ArtistaList.php">
                <i class="fa-solid fa-music me-1"></i>Artistas
            </a>

            <a href="/pweb_1_av02/site/admin/venda/VendaList.php">
                <i class="fa-solid fa-cart-shopping me-1"></i>Vendas
            </a>

            <a href="/pweb_1_av02/site/admin/usuario/UsuarioList.php">
                <i class="fa-solid fa-users me-1"></i>Usuários
            </a>

        </nav>
    </div>
    <?php endif; ?>

    <main>
