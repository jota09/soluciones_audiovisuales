<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Buscador extends S3TablaBD {

    protected $table = 'buscador';
    

}
