<?php
// redireciona se não tiver logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /pweb_1_av02/site/admin/login.php');
    exit;
}
