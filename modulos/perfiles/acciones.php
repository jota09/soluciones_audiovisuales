<?php

if (!defined('s3_entrada') || !s3_entrada):
  die('No es un punto de entrada valido');
endif;

class AccionesPerfiles extends S3Accion {

  public function accionEditar() {
    parent::accionEditar();

    global $aplicacion;

    require_once 'modelo/Lista_maestra.php';
    $ListaMaestra = new Lista_maestra();


    $listasG = $ListaMaestra->obtenerOpcionesGeneral();

    $aplicacion->getVista()->assign('listasG', $listasG);
  }

}
