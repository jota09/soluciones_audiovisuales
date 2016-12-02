<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class AccionesAcuerdos extends S3Accion {

  public function accionEditar() {
    parent::accionEditar();

    global $aplicacion;
    $request = new S3Request();
    $peticion = $request->obtenerPeticion();

    require_once 'modelo/Usuario.php';
    require_once 'modelo/Cuenta.php';
    require_once 'modelo/Actividades.php';
    require_once 'modelo/Acuerdo.php';
    require_once 'modelo/Lista_maestra.php';

    $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js');
    if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
    }

    $usuario = new Usuario();
    $cuenta = new Cuenta();
    $acuerdo = new Acuerdo();
    $ListaMaestra = new Lista_maestra();
    $listasM = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);
    $listasG = $ListaMaestra->obtenerOpcionesGeneral();

    $registro = $acuerdo->obtenerRegistro($peticion['parametros']['registro']);
    $aplicacion->getVista()->assign('scripts', $this->scripts);
    $aplicacion->getVista()->assign('asesores', $usuario->obtenerListaRegistros());
    $aplicacion->getVista()->assign('cuenta', $cuenta->obtenerListaRegistros());
    if ($registro['tipo_acuerdo_id'] == 57) { // SERVICIO
      $actividad = new Actividades();
      $aplicacion->getVista()->assign('cantidad_acuerdo', $actividad->analiticaActividadesCasos($peticion['parametros']['registro']));
    } else if ($registro['tipo_acuerdo_id'] == 58) { // CONVENIO
      $aplicacion->getVista()->assign('cantidad_acuerdo', 0);
    }
    $aplicacion->getVista()->assign('listasM', $listasM);
    $aplicacion->getVista()->assign('listasG', $listasG);

    $aplicacion->getVista()->assign('panel_derecho', 'modulos/' . $this->modulo . '/panel_derecho');
  }

  public function accionDetalle() {

    global $aplicacion;
    $request = new S3Request();
    $request = $request->obtenerPeticion();

    require_once 'modelo/Usuario.php';
    require_once 'modelo/Cuenta.php';
    require_once 'modelo/Lista_maestra.php';

    $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js',
        'librerias/js/amcharts/amcharts.js', 'librerias/js/amcharts/serial.js');
    if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
    }

    $usuario = new Usuario();
    $cuenta = new Cuenta();
    $ListaMaestra = new Lista_maestra();
    $listasM = $ListaMaestra->obtenerOpcionesPorModulo($request['modulo_id']);
    $listasG = $ListaMaestra->obtenerOpcionesGeneral();

    $aplicacion->getVista()->assign('scripts', $this->scripts);
    $aplicacion->getVista()->assign('asesores', $usuario->obtenerListaRegistros());
    $aplicacion->getVista()->assign('cuenta', $cuenta->obtenerListaRegistros());
    $aplicacion->getVista()->assign('listasM', $listasM);
    $aplicacion->getVista()->assign('listasG', $listasG);

    $aplicacion->getVista()->assign('panel_derecho', 'modulos/' . $this->modulo . '/panel_derecho');
  }

}
