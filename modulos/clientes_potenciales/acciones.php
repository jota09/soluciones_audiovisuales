<?php

if (!defined('s3_entrada') || !s3_entrada) {
   die('No es un punto de entrada valido');
}

class AccionesClientes_potenciales extends S3Accion {

   public function accionEditar() {
      parent::accionEditar();

      global $aplicacion;
      $request = new S3Request();
      $peticion = $request->obtenerPeticion();
      $proceso = $request->obtenerVariables();
      require_once 'modelo/Lista_maestra.php';
      require_once 'modelo/ClientePotencial.php';
      require_once 'modelo/Cuenta.php';
      require_once 'modelo/Convenio.php';
      require_once 'modelo/Contacto.php';
      require_once 'modelo/Usuario.php';
      $usu = new Usuario();
      $usuarios_actividades = $usu->obtenerUsuariosActividad();
      $cuenta = new Cuenta();
      $cuentas_actividades = $cuenta->obtenerCuentasActividad();
      $contacto = new Contacto();
      $convenio = new Convenio();
      $contactos_actividades = $contacto->obtenerContactosActividad();
      $aplicacion->getVista()->assign('cuentas_calendario', $cuentas_actividades);
      $aplicacion->getVista()->assign('contactos_calendario', $contactos_actividades);
      $aplicacion->getVista()->assign('usuarios_calendario', $usuarios_actividades);
      $aplicacion->getVista()->assign('convenio', $convenio->obtenerListaRegistros());

      $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js');
      if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
         $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
      }

      $tiempo = new S3Tiempo();
      $ListaMaestra = new Lista_maestra();
      $listasM = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);
      $lista_etapa = $ListaMaestra->obtenerOpcionesxId(6);
      $listasM2 = $ListaMaestra->obtenerOpcionesPorModulo(5);
      $listasG = $ListaMaestra->obtenerOpcionesGeneral();
      $objClientePotencial = new ClientePotencial();

      $registro = $objClientePotencial->obtenerRegistro($peticion['parametros']['registro']);
      $actividades = $objClientePotencial->obtenerRegistroUltimaAct($registro);

      if (isset($peticion['parametros']['registro']) && !empty($peticion['parametros']['registro']) && $peticion['parametros']['registro'] > 0) {
         $aplicacion->getVista()->assign('decendientes', $objClientePotencial->obtenerDescendientes($peticion['parametros']['registro']));
      } else {
         $aplicacion->getVista()->assign('decendientes', array());
      }
      if ($actividades['bandera'] == '') {
         $aplicacion->getVista()->assign('t_transcurrido', tiempoTranscurrido2($actividades['Fecha_inicio']));
      } else {
         $aplicacion->getVista()->assign('t_transcurrido', tiempoTranscurrido2($actividades['Fecha']));
      }
//    __P($aplicacion);
      $aplicacion->getVista()->assign('convertido', $proceso['convertido']);
      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
      $aplicacion->getVista()->assign('listasM', $listasM);
      $aplicacion->getVista()->assign('listasM2', $listasM2);
      $aplicacion->getVista()->assign('cuenta', $cuenta->obtenerListaRegistros(array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0), 1 => array('columna' => 'naturaleza_id', 'condicional' => '=', 'valor' => 33))));
      $aplicacion->getVista()->assign('relacionado', $peticion['modulo_id']);
      $aplicacion->getVista()->assign('t_transcurrido', $tiempo->tiempoTranscurrido($registro, 'clientes'));
      $aplicacion->getVista()->assign('lista_etapa', $lista_etapa);
      $aplicacion->getVista()->assign('listasG', $listasG);
      $aplicacion->getVista()->assign('panel_derecho', 'modulos/' . $this->modulo . '/panel_derecho');
      //__P($proceso, false);
      if (isset($proceso['proceso'])) {
         $aplicacion->getVista()->assign('contenidoModulo', 'modulos/' . $this->modulo . '/convertir');
      }
   }

   public function accionAutocompletar() {
      require_once 'modelo/View_ubicacion.php';
      $request = new S3Request();
      $get['palabra'] = $request->obtenerVariablePGR('palabra');
      $objView_ubicacion = new View_ubicacion();
      die(json_encode($objView_ubicacion->obtenerListaRegistros($get['palabra'])));
   }

   public function accionGuardarClientePotencial() {
      $post = new S3Request();
      $variables = $post->obtenerVariables();

      require_once('modelo/Cuenta.php');
      require_once('modelo/Contacto.php');
      require_once('modelo/ClientePotencial.php');
      $objCuenta = new Cuenta();
      $objContacto = new Contacto();
      $objClientePotencial = new ClientePotencial();
//__P($variables);
      $cta = $objCuenta->convertirCuenta($variables);

      $objContacto->convertirContacto($variables, $cta->id);

      if (isset($variables['crear_oportunidad']) && !empty($variables['crear_oportunidad']) && $variables['crear_oportunidad'] == 1) {
         require_once('modelo/Oportunidad.php');
         $objOportunidad = new Oportunidad();
         $objOportunidad->convertirOportunidad($variables, $cta->id);
      }
//    __P($variables);
      $objClientePotencial->convertir($variables['registro_id']);

      $peticion = array(
          'modulo' => 'clientes_potenciales',
          'accion' => 'editar',
          'parametros' => array(
              'registro' => $variables['registro_id'],
              'convertido' => 1,)
      );


      $post->redireccionar($peticion);
   }

   public function accionListar() {
      global $aplicacion;

      $listado = new S3Listado($this->confModulo['global']['objetoBD']);
      $this->scripts = array('base/librerias/js/datatables/jquery.dataTables.min.js', 'base/librerias/js/select2/select2.min.js', 'assets/js/modulos/' . $this->modulo . '/listar.js');
      $this->estilos = array('base/librerias/css/datatables/jquery.dataTables.min.css', 'base/librerias/js/select2/select2.css', 'base/librerias/js/select2/select2-bootstrap.css');


      $config = $aplicacion->getConfig();
      $config->cargarConfiguracionAplicacion();
      $ajax = $config->getVariableConfig('listado_ajax');

      if (!$ajax) {
         $this->listaRegistros = $listado->obtenerRegistros(true);
      } else {
         $this->listaRegistros = $listado->obtenerRegistros();
      }
      $campos = $listado->obtenerNombresCampos($this->listaRegistros);

      $aplicacion->getVista()->assign('campos', $campos);
      $aplicacion->getVista()->assign('modulo', $this->modulo);
      $aplicacion->getVista()->assign('configModulo', $this->confModulo);
      $aplicacion->getVista()->assign('listaRegistros', $this->listaRegistros);
      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('estilos', $this->estilos);
      $aplicacion->getVista()->assign('_filtros', $this->obtenerFiltros());


      require_once 'modelo/Lista_maestra.php';
      require_once 'modelo/ClientePotencial.php';
      require_once 'modelo/Usuario.php';
      $usu = new Usuario();
      $ListaMaestra = new Lista_maestra();

      $aplicacion->getVista()->assign('listasM', $ListaMaestra->obtenerOpcionesPorModulo(7));
      $aplicacion->getVista()->assign('listasG', $ListaMaestra->obtenerOpcionesGeneral());
      $aplicacion->getVista()->assign('usuarios', $usu->obtenerListaRegistros());
      $aplicacion->getVista()->assign('contenidoModulo', 'modulos/clientes_potenciales/listar');
   }

}

function tiempoTranscurrido2($fecha) {
   $hasta = date('Y-m-d H:i:s');
   $desde = $fecha;
   $datetime1 = new DateTime($desde);
   $datetime2 = new DateTime($hasta);
   # obtenemos la diferencia entre las dos fechas
   $interval = $datetime2->diff($datetime1);
   return $interval;
}
