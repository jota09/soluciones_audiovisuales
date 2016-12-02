<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class AccionesLista_precios extends S3Accion {

  public function accionEditar() {
    parent::accionEditar();
    global $aplicacion;
    $request = new S3Request();
    $peticion = $request->obtenerPeticion();
//    __P($peticion);
    require_once 'modelo/Cuenta.php';
    require_once 'modelo/Precio.php';
    require_once 'modelo/Lista_maestra.php';

    $cuenta = new Cuenta();

    $ListaMaestra = new Lista_maestra();
    $precio = new Precio();
    $listasM = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);
    $listasG = $ListaMaestra->obtenerOpcionesGeneral();

    if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
    }

    unset($this->scripts[5]);
    $aplicacion->getVista()->assign('scripts', $this->scripts);

    $aplicacion->getVista()->assign('registroPrecios', $precio->obtenerPrecioXLista($peticion['parametros']['registro']));
    $aplicacion->getVista()->assign('cuenta', $cuenta->obtenerListaRegistros());
    $aplicacion->getVista()->assign('listasG', $listasG);
    //$aplicacion->getVista()->assign('panel_derecho', 'modulos/' . $this->modulo . '/panel_derecho');
    $aplicacion->getVista()->assign('listasM', $listasM);
  }
 
}
