<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class OportunidadContacto extends S3TablaBD {

  protected $table = 'oportunidad_contacto';
    
    public function guardar_opp_contact($variablesPost) {
        static::insert($variablesPost);
        return 1;
    }
  
}
