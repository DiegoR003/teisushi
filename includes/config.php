<?php
// config.php
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$is_local = in_array($host, ['localhost','127.0.0.1']);

// Ajusta si tu carpeta local no es exactamente /teisushi/
define('BASE_URL', $is_local ? '/teisushi/' : '/'); 

// Desactivar el preloader en local para que no tape todo si falla un asset
define('DISABLE_PRELOADER', $is_local);