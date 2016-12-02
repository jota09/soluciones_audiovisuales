<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class AccionesCuentas extends S3Accion {

  public function accionEditar() {
    parent::accionEditar();

    global $aplicacion;
    $request = new S3Request();
    $peticion = $request->obtenerPeticion();
//    __P($peticion);
    //require_once 'modelo/Oportunidad.php';
    require_once 'modelo/Cotizacion.php';
    require_once 'modelo/Lista_maestra.php';
    require_once 'modelo/Cuenta.php';
    require_once 'modelo/Contacto.php';
    require_once 'modelo/Usuario.php';
    require_once 'modelo/Convenio.php';
    require_once 'modelo/Servicio.php';
    require_once 'modelo/Oportunidad.php';
    $opp = new Oportunidad();
    $usu = new Usuario();
    $usuarios_actividades = $usu->obtenerUsuariosActividad();
    $cuenta = new Cuenta();
    $cuentas_actividades = $cuenta->obtenerCuentasActividad();
    $contacto = new Contacto();
    $convenio = new Convenio();
    $servicio = new Servicio();
    $contactos_actividades = $contacto->obtenerContactosActividad();
    $opps = $opp->obtenerOportunidadxCuenta($peticion['parametros']['registro']);
    $aplicacion->getVista()->assign('cuentas', $cuenta->obtenerListaRegistros());
    $aplicacion->getVista()->assign('cuentas_calendario', $cuentas_actividades);
    $aplicacion->getVista()->assign('contactos_calendario', $contactos_actividades);
    $aplicacion->getVista()->assign('usuarios_calendario', $usuarios_actividades);
    $aplicacion->getVista()->assign('convenio', $convenio->obtenerListaRegistros());
    $aplicacion->getVista()->assign('oportunidad', $opps);


    $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js','librerias/js/amcharts/amcharts.js', 'librerias/js/amcharts/serial.js');
    if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
    }

    $util = new S3Utils();
    //$oportunidad = new Oportunidad();
    $cotizacion = new Cotizacion();
    $ListaMaestra = new Lista_maestra();
    $listasM3 = $ListaMaestra->obtenerOpcionesPorModulo(23);
    $listasM4 = $ListaMaestra->obtenerOpcionesPorModulo(25);
    $listasM = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);
    $listasG = $ListaMaestra->obtenerOpcionesGeneral();
    $listasM2 = $ListaMaestra->obtenerOpcionesPorModulo(5);
    
    if(isset($peticion['parametros']['registro']) && !empty($peticion['parametros']['registro'])){
       //$aplicacion->getVista()->assign('opp_ganadas', '$ '.$oportunidad->valorganadas($peticion['parametros']['registro']));
       $aplicacion->getVista()->assign('opp_ganadas', '$ '.$cotizacion->valorGanadas($peticion['parametros']['registro']));
    }else{
      
    }    

    $aplicacion->getVista()->assign('scripts', $this->scripts);
    $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
    $aplicacion->getVista()->assign('listasM', $listasM);
    $aplicacion->getVista()->assign('listasM2', $listasM2);
    $aplicacion->getVista()->assign('listasM3', $listasM3);
    $aplicacion->getVista()->assign('listasM4', $listasM4);
    $aplicacion->getVista()->assign('caso_listasM', $ListaMaestra->obtenerOpcionesPorModulo(14));
    $aplicacion->getVista()->assign('servicios', $servicio->obtenerListaRegistros());
    $aplicacion->getVista()->assign('cuenta_cotizacion', $cuenta->obtenerListaRegistrosDispobible());
    $aplicacion->getVista()->assign('cuenta', $cuenta->obtenerListaRegistros(array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0), 1 => array('columna' => 'naturaleza_id', 'condicional' => '=', 'valor' => 33))));
    $aplicacion->getVista()->assign('relacionado', $peticion['modulo_id']);
    $aplicacion->getVista()->assign('listasG', $listasG);
    $aplicacion->getVista()->assign('meses', $util->obtener_meses());
   
    $aplicacion->getVista()->assign('panel_derecho', 'modulos/' . $this->modulo . '/panel_derecho');
  }

  public function accionAutocompletar() {
    require_once 'modelo/View_ubicacion.php';
    $request = new S3Request();
    $get['palabra'] = $request->obtenerVariablePGR('palabra');
    $objView_ubicacion = new View_ubicacion();
    die(json_encode($objView_ubicacion->obtenerListaRegistros($get['palabra'])));
  }

}
