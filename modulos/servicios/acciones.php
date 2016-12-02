<?php

if (!defined('s3_entrada') || !s3_entrada) {
      die('No es un punto de entrada valido');
}

class AccionesServicios extends S3Accion {

      public function accionEditar() {
            parent::accionEditar();

            global $aplicacion;
            $request = new S3Request();
            $peticion = $request->obtenerPeticion();

            require_once 'modelo/Actividades.php';
            require_once 'modelo/Lista_maestra.php';
            require_once 'modelo/Servicio_pago.php';

            require_once 'modelo/Cuenta.php';
            require_once 'modelo/Contacto.php';
            require_once 'modelo/Usuario.php';
            $usu = new Usuario();
            $usuarios_actividades = $usu->obtenerUsuariosActividad();
            $cuenta = new Cuenta();
            $cuentas_actividades = $cuenta->obtenerCuentasActividad();
            $contacto = new Contacto();
            $servicio_pago = new Servicio_pago();
            $contactos_actividades = $contacto->obtenerContactosActividad();
            $aplicacion->getVista()->assign('cuentas_calendario', $cuentas_actividades);
            $aplicacion->getVista()->assign('contactos_calendario', $contactos_actividades);
            $aplicacion->getVista()->assign('usuarios_calendario', $usuarios_actividades);

            $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js',
                'librerias/js/amcharts/amcharts.js', 'librerias/js/amcharts/serial.js');
            if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
                  $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
            }

            $ListaMaestra = new Lista_maestra();
            $listasM = $ListaMaestra->obtenerOpcionesPorModulo(25);
            $listasG = $ListaMaestra->obtenerOpcionesGeneral();

            $aplicacion->getVista()->assign('scripts', $this->scripts);
            $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
            $aplicacion->getVista()->assign('cuenta', $cuenta->obtenerListaRegistros());
            $aplicacion->getVista()->assign('pagos', $servicio_pago->obtenerPagosServicio($peticion['parametros']['registro']));
            $aplicacion->getVista()->assign('relacionado', $peticion['modulo_id']);

            $actividad = new Actividades();
            $aplicacion->getVista()->assign('cantidad_acuerdo', $actividad->analiticaActividadesCasos($peticion['parametros']['registro']));
            $aplicacion->getVista()->assign('caso_listasM', $ListaMaestra->obtenerOpcionesPorModulo(14));
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

      public function accioncrear_actividad() {

            require_once 'modelo/Actividades.php';
            $actividades = new Actividades();
            $data = $actividades->guardarActividad();
            die(json_encode($data));
      }
      
   public function accionCrear_servicio() {

    require_once 'modelo/Servicio.php';
    $servicios = new Servicio();
    $data = $servicios->guardar();
    die(json_encode($data));
  }
  
  public function accionServicioXModulo() {

      $request = new S3Request();
      $variables = $request->obtenerVariables();

      require_once 'modelo/Servicio.php';
      $servicio = new Servicio();
      $datos = $servicio->obtener_relacionados($variables);
      die(json_encode($datos));
   }

}
