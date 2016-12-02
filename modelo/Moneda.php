<?php 
if (!defined('s3_entrada') || !s3_entrada) {
	die('No es un punto de entrada valido');
}

class Moneda extends S3TablaBD {
	protected $table = 'moneda';
}