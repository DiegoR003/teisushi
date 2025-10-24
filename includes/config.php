<?php
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$is_local = in_array($host, ['localhost','127.0.0.1']);

// Ajusta esto si en producción cuelga de subcarpeta:
define('BASE_URL', $is_local ? '/teisushi/' : '/');

// Desactiva el preloader en local para que NO tape la página si algo falla.
define('DISABLE_PRELOADER', $is_local);
