<?php

if (!defined('s3_entrada') || !s3_entrada) {
   die('No es un punto de entrada valido');
}

class AccionesOportunidades extends S3Accion {

   public function accionEditar() {
      parent::accionEditar();
      global $aplicacion;
      $request = new S3Request();
      $peticion = $request->obtenerPeticion();

      require_once 'modelo/Convenio.php';
      require_once 'modelo/Lista_maestra.php';
      require_once 'modelo/Oportunidad.php';

      require_once 'modelo/Cuenta.php';
      require_once 'modelo/Contacto.php';
      require_once 'modelo/Usuario.php';
      $usu = new Usuario();
      $usuarios_oportunides = $usu->obtenerUsuariosActividad();
      $cuenta = new Cuenta();
      $cuentas_oportunides = $cuenta->obtenerCuentasActividad();
      $contacto = new Contacto();
      $contactos_oportunides = $contacto->obtenerContactosActividad();
      
      $aplicacion->getVista()->assign('cuentas_calendario', $cuentas_oportunides);
      $aplicacion->getVista()->assign('contactos_calendario', $contactos_oportunides);
      $aplicacion->getVista()->assign('usuarios_calendario', $usuarios_oportunides);


      $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js',
          'librerias/js/amcharts/amcharts.js', 'librerias/js/amcharts/serial.js');
      if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
         $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
      }

      $tiempo = new S3Tiempo();
      $oportunidad = new Oportunidad();
      $convenio = new Convenio();
      $ListaMaestra = new Lista_maestra();
      $listasM2 = $ListaMaestra->obtenerOpcionesPorModulo(23);
      $listasM = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);
      $listasG = $ListaMaestra->obtenerOpcionesGeneral();
      $registro = $oportunidad->obtenerRegistro($peticion['parametros']['registro']);

      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
      $aplicacion->getVista()->assign('cuentas', $cuenta->obtenerListaRegistros());
      if($registro['id'] != ''){
      $contactos_todos = $contacto->obtenerListaRegistrosRol($registro); }
      $aplicacion->getVista()->assign('contactos_todos', $contactos_todos);
      $aplicacion->getVista()->assign('t_transcurrido', $tiempo->tiempoTranscurrido($registro, 'oportunidades'));
      $aplicacion->getVista()->assign('convenio', $convenio->obtenerListaRegistros());
      $aplicacion->getVista()->assign('relacionado', $peticion['modulo_id']);
      $aplicacion->getVista()->assign('listasG', $listasG);
      $aplicacion->getVista()->assign('oportunidad', $oportunidad->obtenerListaRegistros());
      $aplicacion->getVista()->assign('panel_derecho', 'modulos/' . $this->modulo . '/panel_derecho');
      $aplicacion->getVista()->assign('listasM', $listasM);
      $aplicacion->getVista()->assign('listasM2', $listasM2);
   }

   public function accionDetalle() {
      parent::accionEditar();
      global $aplicacion;
      $request = new S3Request();
      $registriId = $request->obtenerVariablePGR('registro');
      $request = $request->obtenerPeticion();
      require_once 'modelo/Usuario.php';
      require_once 'modelo/Moneda.php';
      require_once 'modelo/Cliente.php';
      require_once 'modelo/Lista_maestra.php';
      require_once 'modelo/Oportunidad_oportunid.php';

      $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js', 'base/librerias/js/datatables/jquery.dataTables.min.js');
      $this->estilos = array('base/librerias/js/select2/select2.css', 'base/librerias/css/datatables/jquery.dataTables.min.css', 'base/librerias/js/select2/select2-bootstrap.css');
      if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
         $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
      }

      if (file_exists('assets/css/modulos/' . $this->modulo . '/editar.css')) {
         $this->estilos[] = 'assets/css/modulos/' . $this->modulo . '/editar.css';
      }

      $u = new Usuario();
      $m = new Moneda();
      $c = new Cliente();
      $oportunidad_oportunid = new Oportunidad_oportunid();

      $ListaMaestra = new Lista_maestra();
      $listasM = $ListaMaestra->obtenerOpcionesPorModulo($request['modulo_id']);
      $listasG = $ListaMaestra->obtenerOpcionesGeneral();

      $aplicacion->getVista()->assign('horas', $this->obtenerHoras());
      $aplicacion->getVista()->assign('minutos', $this->obtenerMinutos());
      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('estilos', $this->estilos);
      $aplicacion->getVista()->assign('asesores', $u->obtenerListaRegistros());
      $aplicacion->getVista()->assign('moneda', $m->obtenerListaRegistros());
      $aplicacion->getVista()->assign('cliente', $c->obtenerListaRegistros());
      $aplicacion->getVista()->assign('listarActividad', $oportunidad_oportunid->obtenerActividadXOportunidad($registriId));
      $aplicacion->getVista()->assign('toma_contacto', $listasG['toma_de_contacto']);
      $aplicacion->getVista()->assign('etapa', $listasM['etapas_oportunidad']);
      $aplicacion->getVista()->assign('contenidoModulo', 'general/detalle');
   }

   function accionGuardarActividad() {

      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();

      require_once 'modelo/Actividades.php';
      $oportunides = new Actividades();
      $objActividad = $oportunides->guardar();

      require_once 'modelo/Oportunidad_oportunid.php';
      $oportunidad_oportunid = new Oportunidad_oportunid();

      $oportunidad_oportunid->guardar($variablesPost['registroId'], $objActividad->id);

      die(json_encode($variablesPost));
   }

   public function obtenerHoras() {
      for ($h = 1; $h <= 12; $h++) {
         $horas[] = array(
             'hora' => ($h <= 9) ? '0' . $h : $h
         );
      }
      return $horas;
   }

   public function obtenerMinutos() {
      $m = 0;
      for ($h = 0; $h < 4; $h++) {
         $minutos[] = array(
             'minutos' => ($m < 1) ? '0' . $m : $m
         );
         $m += 15;
      }
      return $minutos;
   }
   
   public function accionCrear_oportunidad() {

    require_once 'modelo/Oportunidad.php';
    $oportunides = new Oportunidad();
    $data = $oportunides->guardarOportunidad();
    die(json_encode($data));
  }

   public function accionOportunidadXModulo() {

      $request = new S3Request();
      $variables = $request->obtenerVariables();

      require_once 'modelo/Oportunidad.php';
      $oportunidad = new Oportunidad();
      $datos = $oportunidad->obtener_relacionados($variables);
      die(json_encode($datos));
   }

   public function accionOportunidadXCuenta() {

      $request = new S3Request();
      $variables = $request->obtenerVariables();

      require_once 'modelo/Oportunidad.php';
      $oportunidad = new Oportunidad();

      $datos = $oportunidad->obtenerOportunidadesxCuenta($variables);
      die(json_encode($datos));
   }

   public function accionObtenerGanadasXMeses() {
      $request = new S3Request();
      $variables = $request->obtenerVariables();

      require_once 'modelo/Oportunidad.php';
      $oportunidad = new Oportunidad();

      $datos = $oportunidad->obtenerOportunidadesGanadasXMes($variables);
      die(json_encode($datos));
   }

   public function accionObtenerOportunidadesXConvenio() {
      $request = new S3Request();
      $variables = $request->obtenerVariables();

      require_once 'modelo/Oportunidad.php';
      $oportunidad = new Oportunidad();

      $datos = $oportunidad->obtenerOportunidadesXConvenio($variables);
      die(json_encode($datos));
   }

     public function accionFiltrarOportunidades() {

      $request = new S3Request();
      $peticion = $request->obtenerVariables();

      require_once 'modelo/Oportunidad.php';
      $oportunidad = new Oportunidad();

      $data = $oportunidad->filtrarOportunidades($peticion);
      die(json_encode($data));
   }
   
   public function accionListar() {
      global $aplicacion;
      parent::accionListar();
      
      require_once 'modelo/Lista_maestra.php';
      require_once 'modelo/Cuenta.php';
      require_once 'modelo/Usuario.php';
      
      $usu = new Usuario();
      $cuenta = new Cuenta();
      $ListaMaestra = new Lista_maestra();
     
      $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
      $aplicacion->getVista()->assign('cuentas', $cuenta->obtenerListaRegistros());
      $aplicacion->getVista()->assign('listasM', $ListaMaestra->obtenerOpcionesPorModulo(5));
      $aplicacion->getVista()->assign('listasG', $ListaMaestra->obtenerOpcionesGeneral());
      $aplicacion->getVista()->assign('contenidoModulo', 'modulos/oportunidades/listar');
          
   }
   
    public function accionCrear_opp_contact() {
    
    $request = new S3Request();
    $variablesPost = $request->obtenerVariables();
    require_once 'modelo/Oportunidad_contacto.php';
    $opp_contacto = new OportunidadContacto();
    $data = $opp_contacto->guardar_opp_contact($variablesPost);
    die(json_encode($data));
  }
  
   
}
