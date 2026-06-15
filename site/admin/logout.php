<?php
// encerra a sessão
session_start();
session_destroy();
header('Location: /pweb_1_av02/site/admin/login.php');
exit;
