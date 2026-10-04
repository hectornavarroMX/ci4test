<?php

use CodeIgniter\Boot;
use Config\Paths;

if (str_starts_with(PHP_SAPI, 'cgi')) {
    exit("Se requiere php-cli para ejecutar el servidor MCP.\n");
}

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set('display_errors', '0');

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
chdir(FCPATH);

require FCPATH . '../app/Config/Paths.php';
$paths = new Paths();
require $paths->systemDirectory . '/Boot.php';

// Pasar --no-header para deshabilitar el encabezado de Spark
$_SERVER['argv'] = ['spark', 'mcp:serve', '--no-header'];
$_SERVER['argc'] = 3;

exit(Boot::bootSpark($paths));
