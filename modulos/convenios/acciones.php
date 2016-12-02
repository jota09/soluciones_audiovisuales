<?php

if (!defined('s3_entrada') || !s3_entrada) {
   die('No es un punto de entrada valido');
}

class AccionesConvenios extends S3Accion {

   public function accionEditar() {
      parent::accionEditar();

      global $aplicacion;
      $request = new S3Request();
      $peticion = $request->obtenerPeticion();

      require_once 'modelo/Lista_maestra.php';
      require_once 'modelo/Cuenta.php';
      require_once 'modelo/Contacto.php';
      require_once 'modelo/Usuario.php';
      require_once 'modelo/Convenio.php';

      $convenio = new Convenio();
      $usu = new Usuario();
      $usuarios_actividades = $usu->obtenerUsuariosActividad();
      $cuenta = new Cuenta();
      $cuentas_actividades = $cuenta->obtenerCuentasActividad();
      $contacto = new Contacto();
      $contactos_actividades = $contacto->obtenerContactosActividad();
      $aplicacion->getVista()->assign('cuentas_calendario', $cuentas_actividades);
      $aplicacion->getVista()->assign('contactos_calendario', $contactos_actividades);
      $aplicacion->getVista()->assign('usuarios_calendario', $usuarios_actividades);

      $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js',
          'librerias/js/amcharts/amcharts.js', 'librerias/js/amcharts/serial.js');
      if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
         $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
      }

      $annios = array();
      for ($i = -1; $i < 3; $i++) {
         $annios[]['anio'] = date('Y') + $i;
      }

      $ListaMaestra = new Lista_maestra();
      $listasM = $ListaMaestra->obtenerOpcionesPorModulo(25);
          $listasM2 = $ListaMaestra->obtenerOpcionesPorModulo(5);

      $listasG = $ListaMaestra->obtenerOpcionesGeneral();

      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('relacionado', $peticion['modulo_id']);
      $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
      $aplicacion->getVista()->assign('cuenta', $cuenta->obtenerListaRegistros());
    $aplicacion->getVista()->assign('convenio', $convenio->obtenerListaRegistros());

      $aplicacion->getVista()->assign('annios', $annios);

      $aplicacion->getVista()->assign('listasM', $listasM);
          $aplicacion->getVista()->assign('listasM2', $listasM2);

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
   
   public function accionCrear_convenio() {

    require_once 'modelo/Convenio.php';
    $convenios = new Convenio();
    $data = $convenios->guardar();
    die(json_encode($data));
  }
  
  public function accionConvenioXModulo() {

      $request = new S3Request();
      $variables = $request->obtenerVariables();

      require_once 'modelo/Convenio.php';
      $convenio = new Convenio();
      $datos = $convenio->obtener_relacionados($variables);
      die(json_encode($datos));
   }

}
