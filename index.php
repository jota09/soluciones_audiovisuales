<?php

session_start();
if (!defined('s3_entrada')) {
    define('s3_entrada', true);
}

require_once('base/main.controller.php');
$aplicacion = new Aplicacion();

$aplicacion->iniciar();
$aplicacion->procesar();
$aplicacion->finalizar();
