<?php



if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class AccionesContactos extends S3Accion {

  public function accionEditar() {
    parent::accionEditar();

    global $aplicacion;

    require_once 'modelo/Lista_maestra.php';
    require_once 'modelo/Cuenta.php';
    require_once 'modelo/Contacto.php';
    require_once 'modelo/Convenio.php';
    require_once 'modelo/Usuario.php';
    require_once 'modelo/Oportunidad.php';
    $opp = new Oportunidad();
    
    $usu = new Usuario();
    $usuarios_actividades = $usu->obtenerUsuariosActividad();
    $cuenta = new Cuenta();
    $cuentas_actividades = $cuenta->obtenerCuentasActividad();
    $contacto = new Contacto();
    $contactos_actividades = $contacto->obtenerContactosActividad();
    $aplicacion->getVista()->assign('cuentas_calendario', $cuentas_actividades);
    $aplicacion->getVista()->assign('contactos_calendario', $contactos_actividades);
    $aplicacion->getVista()->assign('usuarios_calendario', $usuarios_actividades);

    $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js');
    if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
    }

    $tiempo = new S3Tiempo();
    $ListaMaestra = new Lista_maestra();
    $request = new S3Request();
    $convenio = new Convenio();
    $peticion = $request->obtenerPeticion();
    $listasM = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);
    $listasM2 = $ListaMaestra->obtenerOpcionesPorModulo(5);
    $listasG = $ListaMaestra->obtenerOpcionesGeneral();

    $registro = $contacto->obtenerRegistro($peticion['parametros']['registro']);
//    __P($registro['cuenta_id']);
    $opps = $opp->obtenerListaRegistrosxCuenta($registro['cuenta_id']);
    $actividades = $contacto->obtenerRegistroUltimaAct($registro);
    $aplicacion->getVista()->assign('cuenta', $cuenta->obtenerListaRegistros(array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0), 1 => array('columna' => 'naturaleza_id', 'condicional' => '=', 'valor' => 33))));
    $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
   if($actividades['bandera'] == ''){
      $aplicacion->getVista()->assign('t_transcurrido', tiempoTranscurrido2($actividades['Fecha_inicio']));
   }
   else{
      $aplicacion->getVista()->assign('t_transcurrido', tiempoTranscurrido2($actividades['Fecha']));
   }
//   __P($aplicacion);
    $aplicacion->getVista()->assign('listasG', $listasG); 
    $aplicacion->getVista()->assign('relacionado', $peticion['modulo_id']);
    $aplicacion->getVista()->assign('listasM2', $listasM2);
    $aplicacion->getVista()->assign('listasM', $listasM);
    $aplicacion->getVista()->assign('oportunidades', $opps);
    $aplicacion->getVista()->assign('convenio', $convenio->obtenerListaRegistros());
    $aplicacion->getVista()->assign('panel_derecho', 'modulos/' . $this->modulo . '/panel_derecho');
  }

  public function accionAutocompletar() {
    require_once 'modelo/View_ubicacion.php';
    $request = new S3Request();
    $get['palabra'] = $request->obtenerVariablePGR('palabra');
    $objView_ubicacion = new View_ubicacion();
    die(json_encode($objView_ubicacion->obtenerListaRegistros($get['palabra'])));
  }
  
  public function accionComprorbarDuplicado() {
    require_once 'modelo/Cuenta.php';
    $objCliente = new Cuenta();
    $request = new S3Request();
    $post = $request->obtenerVariables();

    if ($post['term'] != '') {
      require_once 'modelo/Cuenta_telefono.php';
      require_once 'modelo/Cuenta_correo.php';

      $duplicados = $objCliente->comprobarDuplicadoXtermino($post['term']);
      $duplicadosArray = array();
      foreach ($duplicados as $key => $duplicado) {
        $objCtaTel = new Cuenta_telefono();
        $objCtaCorreo = new Cuenta_correo();
        $duplicados[$key]['telefonos'] = $objCtaTel->obtenerTelxIdCli($duplicado['id']);
        $duplicados[$key]['correos'] = $objCtaCorreo->obtenerCorreoxIdCli($duplicado['id']);
      }
      die(json_encode($duplicados));
    }

    $existe = false;
    if (count($objCliente->comprobarDuplicado($post['propietario_nombre'], $post['propietario_apellido'], $post['propietario_naturaleza_id'])) > 0) {
      $existe = true;
    }

    die(json_encode(array($post['fieldId'], !$existe)));
  }

  function accionObtenerInformaA() {

    $request = new S3Request();
    $vars = $request->obtenerVariables();

    require_once 'modelo/Contacto.php';
    $contacto = new Contacto();

    die(json_encode($contacto->obtenerListaRegistros(array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0), 0 => array('columna' => 'cuenta_id', 'condicional' => '=', 'valor' => $vars['cuenta_id'])))));
  }

  public function accionContactosXModulo() {

    $request = new S3Request();
    $variables = $request->obtenerVariables();

    require_once 'modelo/Contacto.php';
    $contacto = new Contacto();

    $datos = $contacto->obtener_relacionados($variables);
    die(json_encode($datos));
  }
  
 public function accionCrear_contacto() {

    require_once 'modelo/Contacto.php';
    $contactos = new Contacto();
    $data = $contactos->guardarContacto();
    die(json_encode($data));
  }
  
 public function accionListar() {
      global $aplicacion;
      parent::accionListar();
      
      require_once 'modelo/Lista_maestra.php';
      $ListaMaestra = new Lista_maestra();
      require_once 'modelo/Cuenta.php';
      require_once 'modelo/Usuario.php';
      $cuenta = new Cuenta();
      $usu = new Usuario();
      $aplicacion->getVista()->assign('listasM', $ListaMaestra->obtenerOpcionesPorModulo(22));
      $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
      $aplicacion->getVista()->assign('cuentas', $cuenta->obtenerListaRegistros());
      $aplicacion->getVista()->assign('listasG', $ListaMaestra->obtenerOpcionesGeneral());
      $aplicacion->getVista()->assign('contenidoModulo', 'modulos/contactos/listar');
          
   }
   
   public function accionCrear_contact_opp() {
    
    $request = new S3Request();
    $variablesPost = $request->obtenerVariables();
    require_once 'modelo/Oportunidad_contacto.php';
    $opp_contacto = new OportunidadContacto();
    $data = $opp_contacto->guardar_opp_contact($variablesPost);
    die(json_encode($data));
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
