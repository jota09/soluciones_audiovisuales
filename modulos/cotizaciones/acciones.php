<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class AccionesCotizaciones extends S3Accion {

    public function accionEditar() {
        parent::accionEditar();
        global $aplicacion;
        $request = new S3Request();
        $peticion = $request->obtenerPeticion();
        require_once 'modelo/Usuario.php';
        require_once 'modelo/Cotizacion.php';
        require_once 'modelo/Cuenta.php';
        require_once 'modelo/Oportunidad.php';
        require_once 'modelo/Cotizacion_detalle.php';
        require_once 'modelo/Lista_maestra.php';

        $u = new Usuario();
        $cuenta = new Cuenta();
        $cotizacionDet = new Cotizacion_detalle();
        $cotizacion = new Cotizacion();
        $oportunidad = new Oportunidad();
        $tiempo = new S3Tiempo();

        $ListaMaestra = new Lista_maestra();
        $listasM = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);
        $listasG = $ListaMaestra->obtenerOpcionesGeneral();

        $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js', 'librerias/js/ckeditor/ckeditor.js');
        if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
            $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
        }

        $registro = $cotizacion->obtenerRegistro($peticion['parametros']['registro']);

        if (isset($registro['cuenta_id']) && !empty($registro['cuenta_id'])) {
            $cuentaId = $registro['cuenta_id'];
            $aplicacion->getVista()->assign('oportunidad', $oportunidad->obtenerOportunidadXCuenta($cuentaId));
        }
        $aplicacion->getVista()->assign('registro', $registro);
        $aplicacion->getVista()->assign('scripts', $this->scripts);
        $aplicacion->getVista()->assign('asesores', $u->obtenerListaRegistros());
        $aplicacion->getVista()->assign('cuenta', $cuenta->obtenerListaRegistros());
        $aplicacion->getVista()->assign('cuenta_cotizacion', $cuenta->obtenerListaRegistrosDispobible());
        $aplicacion->getVista()->assign('t_transcurrido', $tiempo->tiempoTranscurrido($registro, 'cotizaciones'));
        $aplicacion->getVista()->assign('detalles', $cotizacionDet->obtenerDetalleCotizacion($peticion['parametros']['registro']));
        $aplicacion->getVista()->assign('listasG', $listasG);
        $aplicacion->getVista()->assign('panel_derecho', 'modulos/' . $this->modulo . '/panel_derecho');
        $aplicacion->getVista()->assign('listasM', $listasM);
    }

    public function accionListar() {
        global $aplicacion;
        parent::accionListar();

        require_once 'modelo/Lista_maestra.php';
        require_once 'modelo/ClientePotencial.php';
        require_once 'modelo/Usuario.php';
        require_once 'modelo/Cuenta.php';
        require_once 'modelo/Cotizacion.php';
        require_once 'modelo/Oportunidad.php';
        $usu = new Usuario();
        $cotizacion = new Cotizacion();
        $cuenta = new Cuenta();
        $opp = new Oportunidad();
        $ListaMaestra = new Lista_maestra();

        $aplicacion->getVista()->assign('listasM', $ListaMaestra->obtenerOpcionesPorModulo(23));
        $aplicacion->getVista()->assign('listasG', $ListaMaestra->obtenerOpcionesGeneral());
        $aplicacion->getVista()->assign('usuarios', $usu->obtenerListaRegistros());
        $aplicacion->getVista()->assign('cotizaciones', $cotizacion->obtenerListaRegistros());
        $aplicacion->getVista()->assign('cuentas', $cuenta->obtenerListaRegistros());
        $aplicacion->getVista()->assign('oportunidades', $opp->obtenerListaRegistros());
        $aplicacion->getVista()->assign('contenidoModulo', 'modulos/cotizaciones/listar');
    }

    function accionGuardarActividad() {

        $request = new S3Request();
        $variablesPost = $request->obtenerVariables();

        require_once 'modelo/Actividades.php';
        $actividades = new Actividades();
        $objActividad = $actividades->guardar();

        require_once 'modelo/Oportunidad_actividad.php';
        $oportunidad_actividad = new Oportunidad_actividad();

        $oportunidad_actividad->guardar($variablesPost['registroId'], $objActividad->id);

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

    public function accionObtenerxCuenta() {
        $request = new S3Request();
        $post = $request->obtenerVariables();
        require_once 'modelo/Oportunidad.php';
        $objOportunidad = new Oportunidad();
        die(json_encode($objOportunidad->obtenerxCuenta($post['cliente_id'])));
    }

    public function accionCrearNegociacion() {
        global $aplicacion;
        $request = new S3Request();
        $post = $request->obtenerVariables();

        require_once 'modelo/Oportunidad.php';
        $objOportunidad = new Oportunidad();
        $objOportunidad->gestion_inmueble_id = $post['gestion_inmueble_id'];
        $objOportunidad->cliente_id = $post['cliente_id'];
        $objOportunidad->asesor_asignado_id = $post['asesor_asignado_id'];
        $objOportunidad->toma_contacto_id = $post['toma_contacto_id'];
        $objOportunidad->valor = $post['valor'];
        $objOportunidad->moneda_id = $post['moneda_id'];
        $objOportunidad->fecha_cierre = $post['fecha_cierre'];
        $objOportunidad->etapa_id = $post['etapa_id'];
        $objOportunidad->descripcion = $post['descripcion'];
        $objOportunidad->fecha_creacion = date('Y-m-d H:i:s');
        $objOportunidad->creado_por = $aplicacion->getUsuario()->getId();
        $objOportunidad->save();
        die(json_encode($objOportunidad->id));
    }

    public function accionCotizacionesXModulo() {

        $request = new S3Request();
        $variables = $request->obtenerVariables();

        require_once 'modelo/Cotizacion.php';
        $cotizacion = new Cotizacion();
//      __P($variables);
        $datos = $cotizacion->obtener_relacionados($variables);

        die(json_encode($datos));
    }

    public function accionObtenerPDF() {
        $request = new S3Request();
        $post = $request->obtenerVariables();
        require_once 'librerias/php/dompdf/crearPDF.php';
        $pdf = $this->generarPlantilla($post['registro']);
//      __P($post);
        new crearPDF($pdf, "Cotizacion_" . $post['registro']);
    }

    function generarPlantilla($id = '') {

        global $aplicacion;
        $request = new S3Request();
        $peticion = $request->obtenerPeticion();
        
        $current_id = $peticion['parametros']['registro'];
        if (!empty($id)) {
            $current_id = $id;
        }
        require_once 'modelo/Usuario.php';
        require_once 'modelo/Cotizacion.php';
        require_once 'modelo/Cuenta.php';
        require_once 'modelo/Oportunidad.php';
        require_once 'modelo/Cotizacion_detalle.php';
        require_once 'modelo/Lista_maestra.php';

        $u = new Usuario();
        $cuenta = new Cuenta();
        $cotizacionDet = new Cotizacion_detalle();
        $cotizacion = new Cotizacion();
        $oportunidad = new Oportunidad();

        $ListaMaestra = new Lista_maestra();
        $listasM = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);
        $listasG = $ListaMaestra->obtenerOpcionesGeneral();

        if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
            $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
        }

        $registro = $cotizacion->obtenerRegistro($current_id);

        if (isset($registro['cuenta_id']) && !empty($registro['cuenta_id'])) {
            $cuentaId = $registro['cuenta_id'];
            $registro['oportunidad'] = $oportunidad->obtenerOportunidadXCuenta($cuentaId);
        }

      $registro['asesores'] = $u->obtenerListaRegistros();
      $registro['cuenta'] = $cuenta->obtenerListaRegistros();
      $registro['detalles'] = $cotizacionDet->obtenerDetalleCotizacion($peticion['parametros']['registro']);
      $registro['listasG'] = $listasG;
      $registro['listasM'] = $listasM;
      $hoy = $this->fecha_espanol();
//      __P($registro);
      $aplicacion->getVista()->assign('hoy',$hoy);
      $registro['total'] = number_format($registro['total'], 0, '', '.');      
      $aplicacion->getVista()->assign('registro', $registro);
      if ($registro['linea_id']== 71 ){
         $html = $aplicacion->getVista()->draw("modulos/cotizaciones/pdf_cotizacion_1", true);}
      if ($registro['linea_id']== 72 || $registro['linea_id']==73 || $registro['linea_id']== 74){
         $html = $aplicacion->getVista()->draw("modulos/cotizaciones/pdf_cotizacion", true);}
      if ($registro['linea_id']== 75){
         $html = $aplicacion->getVista()->draw("modulos/cotizaciones/pdf_cotizacion_2", true);}
      return $html;
   }

    public function accionEnviarCotizacion() {
        $request = new S3Request();
        $post = $request->obtenerVariables();

        require_once 'modelo/Cotizacion.php';
        $cotizacion = new Cotizacion();
        die(json_encode($cotizacion->enviarCorreos($post)));
    }

    public function accionObtenerGanadasXMeses() {
        $request = new S3Request();
        $variables = $request->obtenerVariables();

        require_once 'modelo/Cotizacion.php';
        $cotizacion = new Cotizacion();

      $datos = $cotizacion->obtenerGanadasXMes($variables);
      die(json_encode($datos));
   }
   
   public function accionCrear_cotizacion() {
    require_once 'modelo/Cotizacion.php';
    $cotizaciones = new Cotizacion();
    $data = $cotizaciones->guardarCotizacion();
    die(json_encode($data));
  }
  
  public function fecha_espanol(){
     $hoy = getdate();
     if($hoy['month']=="January") {$hoy['month'] = "Enero";}
     if($hoy['month']=="February") {$hoy['month'] = "Febrero";}
     if($hoy['month']=="March") {$hoy['month'] = "Marzo";}
     if($hoy['month']=="April") {$hoy['month'] = "Abril";}
     if($hoy['month']=="May") {$hoy['month'] = "Mayo";}
     if($hoy['month']=="June") {$hoy['month'] = "Junio";}
     if($hoy['month']=="July") {$hoy['month'] = "Julio";}
     if($hoy['month']=="August") {$hoy['month'] = "Agosto";}
     if($hoy['month']=="September") {$hoy['month'] = "Septiembre";}
     if($hoy['month']=="October") {$hoy['month'] = "Octubre";}
     if($hoy['month']=="November") {$hoy['month'] = "Noviembre";}
     if($hoy['month']=="December") {$hoy['month'] = "Diciembre";}
  
     return $hoy;
     }
  
}
