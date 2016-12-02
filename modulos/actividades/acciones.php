<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class AccionesActividades extends S3Accion {

  public function accionEditar() {

    if ($_REQUEST['ajax'] == 'true') {
      require_once 'modelo/Actividades.php';
      $actividad = new Actividades();
      $actividad->guardarAjax();
      $this->accionObtenerActividades();
      exit();
    }

    global $aplicacion;
    parent::accionEditar();

    $aplicacion->getVista()->assign('horas', $this->obtenerHoras());
    $aplicacion->getVista()->assign('minutos', $this->obtenerMinutos());
    require_once 'modelo/Lista_maestra.php';
    require_once 'modelo/Actividades.php';
    require_once 'modelo/Cuenta.php';

    require_once 'modelo/Invitados.php';

    require_once 'modelo/Usuario.php';
    $usu = new Usuario();
    $usuarios = $usu->obtenerUsuarios();
    $cuenta = new Cuenta();
    $ListaMaestra = new Lista_maestra();
    $request = new S3Request();
    $peticion = $request->obtenerPeticion();
    $ver = new S3Ver($this->confModulo['global']['objetoBD']);
    $registro = $ver->obtenerRegistro($this->registro);
//    __P($registro);
    if($registro['relacionado']==7){
       require_once 'modelo/ClientePotencial.php';
       $objClientePotencial = new ClientePotencial();
       $registro = $objClientePotencial->obtenerClientesPotenciales();
       $aplicacion->getVista()->assign('registro_relacionado', $registro);
    }
    if($registro['relacionado']==12){
       require_once 'modelo/Cuenta.php';
       $cuenta = new Cuenta();
       $registro = $cuenta->obtenerClientes();
       $aplicacion->getVista()->assign('registro_relacionado', $registro);
    }
    $listas = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);
    $aplicacion->getVista()->assign('listas', $listas);
    require_once 'modelo/_ModuloRelacion.php';
    $objModulo = new ModuloRelacion();
    $modulos_actividades = $objModulo->obtener_modulos_act();

    $inv = new Invitados();
    $invitados = $inv->obtenerInvitadosxActividad($request->obtenerVariablePGR('registro'));

    $estado = array();
    $estado['registro'] = array();

    $relacionado = array();
    $relacionado['registro'] = array();
    
    $aplicacion->getVista()->assign('cuentas', $cuenta->obtenerListaRegistros());
    $aplicacion->getVista()->assign('cntinv', count($invitados));
    $aplicacion->getVista()->assign('invitados', $invitados);
    $aplicacion->getVista()->assign('modulos_actividades', $modulos_actividades);
    $aplicacion->getVista()->assign('relacionado', $relacionado['registro']);
    //$aplicacion->getVista()->assign('cuentas', $cuentas_potencial);
    $aplicacion->getVista()->assign('usuarios', $usuarios);
        $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
//    __P($aplicacion);
  }

  public function accionObtenerActividades() {
    global $aplicacion;
    require_once 'modelo/Actividades.php';
    $actividad = new Actividades();
//__P($_REQUEST);
    if (!$_REQUEST['id']) {
      $listaRegistros = $actividad->obtenerListaRegistros2();

      foreach ($listaRegistros as $list) {
        if ($list['usuario_id'] == $aplicacion->getUsuario()->getId()) {
          if ($list['tipo'] == 38 || $list['tipo'] == "38") {
            $color = '#27a38b';
          } else if ($list['tipo'] == 39 || $list['tipo'] == "39") {
            $color = '#e24939';
          } else if ($list['tipo'] == 40 || $list['tipo'] == "40") {
            $color = '#3a91cc';
          }

          // __P($list['tipo'], false);
          $lista[] = array(
              'id' => $list['id'],
              'title' => $list['nombre'],
              'start' => $list['fecha_inicio'] . 'T' . $list['hora_inicio'],
              'end' => $list['fecha_fin'] . 'T' . $list['hora_fin'],
              "color" => $color,
          );
        }
      }//__P($lista);
    } elseif ($_REQUEST['actualizar']) {
      $actividad->guardarAjax(true);
    } else {
      $list = $actividad->obtenerRegistro($_REQUEST['id']);
      $listaHoraInicial = explode(":", $list['hora_inicio']);
      $listaHoraFin = explode(":", $list['hora_fin']);
      $actividad->desFormatear($list);
      $lista = array(
          'id' => $list['id'],
          'title' => $list['nombre'],
          'start' => $list['fecha_inicio'] . 'T' . $list['hora_inicio'],
          'end' => $list['fecha_fin'] . 'T' . $list['hora_fin'],
          'fecha_inicio_minutos' => $listaHoraInicial[1],
          'fecha_inicio_hora' => $listaHoraInicial[0],
          'fecha_inicio_am' => $list['meridiano_inicio'],
          'fecha_fin_minutos' => $listaHoraFin[1],
          'fecha_fin_hora' => $listaHoraFin[0],
          'fecha_fin_am' => $list['meridiano_fin'],
          'tipo' => $list['tipo'],
          'relacionado' => $list['relacionado'],
          'relacionado_id' => $list['relacionado_id'],
          'estado' => $list['estado'],
          'aviso' => $list['aviso'],
          'prioridad' => $list['prioridad'],
          'contacto' => $list['contacto'],
          'duracion' => $list['duracion'],
          'tipo_llamada' => $list['tipo_llamada'],
          'lugar' => $list['lugar'],
          'descripcion' => $list['descripcion'],
      );
    }
    die(json_encode($lista));
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

  protected function desFormatear(&$lista) {

    $fecha_inicio_hora = strtotime($lista['fecha_inicio']);
    $fecha_inicio_hora = explode(':', date('h:i:A', $fecha_inicio_hora));
    $lista['fecha_inicio_hora'] = $fecha_inicio_hora[0];
    $lista['fecha_inicio_minutos'] = $fecha_inicio_hora[1];
    $lista['fecha_inicio_am'] = $fecha_inicio_hora[2];
    $fecha_inicio = explode(' ', $lista['fecha_inicio']);
    $lista['fecha_inicio'] = $fecha_inicio[0];

    $fecha_fin_hora = strtotime($lista['fecha_fin']);
    $fecha_fin_hora = explode(':', date('h:i:A', $fecha_fin_hora));
    $lista['fecha_fin_hora'] = $fecha_fin_hora[0];
    $lista['fecha_fin_minutos'] = $fecha_fin_hora[1];
    $lista['fecha_fin_am'] = $fecha_fin_hora[2];
    $fecha_fin = explode(' ', $lista['fecha_fin']);
    $lista['fecha_fin'] = $fecha_fin[0];
    return $lista;
  }

  public function accioncrear_actividad() {

    require_once 'modelo/Actividades.php';
    $actividades = new Actividades();
    $data = $actividades->guardarActividad();
    die(json_encode($data));
  }

  public function accionobtener_actividadesxmodulo() {


    require_once 'modelo/Actividades.php';
    $actividades = new Actividades();
   
    $request = new S3Request();
    $variables = $request->obtenerVariables();
    
    $datos = $actividades->obtener_actividadesxmodulo($variables);
    die(json_encode($datos));
  }

  public function accioneliminar_actividad() {
    $id = $_REQUEST['id'];
    require_once 'modelo/Actividades.php';
    $actividades = new Actividades();
    $actividades->eliminar_actividad_por_id($id);
    die(json_encode(1));
  }

  public function accionobtener_registrosxmodulo() {

    $tabla = $_REQUEST['tabla'];
    $selecion = $_REQUEST['selecion'];
    require_once 'modelo/Actividades.php';
    $actividades = new Actividades();
    $data = $actividades->obtener_registrosxrelacionado($tabla, $selecion);
    die(json_encode($data));
  }

  public function accionobtenerinvitados() {
    require_once 'modelo/Invitados.php';
//        __P($_REQUEST);
    $id = $_REQUEST['id'];
    $inv = new Invitados();
    $invitados = $inv->obtenerInvitadosxActividad($id);
    die(json_encode($invitados));
  }

  public function accionobtenerNumActividadesByMes() {
    require_once 'modelo/Actividades.php';
    $objActividades = new Actividades();
    $request = new S3Request();
    $act = $objActividades->obtenerNumActividadesXMes($request->obtenerVariablePGR('mes'), $request->obtenerVariablePGR('id'));
    die(json_encode($act));
  }

  public function accionFiltrarActividades() {

      $request = new S3Request();
      $peticion = $request->obtenerVariables();

      require_once 'modelo/Actividades.php';
      $actividades = new Actividades();

      $data = $actividades->filtrarActividades($peticion);
      die(json_encode($data));
   }
   
}
