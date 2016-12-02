<?php

if (!defined('s3_entrada') || !s3_entrada) {
   die('No es un punto de entrada valido');
}

class Cotizacion extends S3TablaBD {

   protected $table = 'cotizacion';

   public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

      $bdObjeto = static::query()
              ->selectRaw("cotizacion.id, TRIM(CONCAT(IFNULL(cta.nombres,cta.nombre_comercial),' ',IFNULL(cta.apellidos,''))) AS cuenta, op.referencia as oportunidad, numero_factura as 'Numero_factura', cotizacion.linea_str as 'linea', fecha_factura as 'fecha_factura', cotizacion.fecha_cierre ,CONCAT(us.nombres,' ',us.apellidos) AS asesor")
              ->join('oportunidad AS op', 'op.id', '=', 'cotizacion.oportunidad_id')
              ->join('cuenta AS cta', 'cta.id', '=', 'cotizacion.cuenta_id')
              ->join('usuario AS us', 'us.id', '=', 'cotizacion.asesor_id')
              ->leftjoin('opcion_lista_maestra AS olmL', 'olmL.id', '=', 'cotizacion.linea_id')
              ->leftjoin('opcion_lista_maestra AS olmE', 'olmE.id', '=', 'cotizacion.etapa_id');

      foreach ($where AS $w) {

         if (in_array($w['columna'], $this->camposTabla)) {
            $bdObjeto->where($this->table . '.' . $w['columna'], $w['condicional'], $w['valor']);
         }
      }

      $filtro = array
          ("filtroCuenta" => "cta",
          "filtroLinea" => "olmL",
          "filtroEtapa" => "olmE",
          "filtroOportunidad" => "op",
          "filtroFechaCierre21" => "cotizacion",
          "filtroFechaFactura22" => "cotizacion",
          "filtroNumeroFactura" => "cotizacion",
          "filtroAsignado" => "us",
      );
      if ($ajaxTabla) {
         $this->obtenerListaRegistrosAjaxTablaAux($bdObjeto, $filtro);
      }


      if ($only) {
         $bdObjeto->take(1)->skip(0);
      }
      $bdObjeto->orderBy($this->table . '.id', 'DESC');
      $arrayCli = $bdObjeto->get()->toArray();

      if ($ajaxTabla) {
         $this->postObtenerListaRegistrosAjaxTabla($arrayCli);
      }

      return $arrayCli;
   }

   public function obtenerRegistro($registro) {

      if (!empty($registro)) {
         $bdObjeto = static::query()
                 ->selectRaw("cotizacion.*, olm.nombre as iva, olmV.nombre as version")
                 ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
                 ->join("opcion_lista_maestra as olmV", "olmV.id", "=", "cotizacion.version_id")
                 ->whereRaw("cotizacion.id = " . $registro);

         $arrayCli = $bdObjeto->get()->toArray();

         for ($i = 0; $i < sizeof($arrayCli); $i++) {
            $arrayCli[$i]['descuento'] = (int) $arrayCli[$i]['descuento'];
            $arrayCli[$i]['subtotal_descuento'] = $arrayCli[$i]['subtotal'] - $arrayCli[$i]['descuento'];
            $arrayCli[$i]['valor_iva'] = $arrayCli[$i]['subtotal_descuento'] * ( (int) $arrayCli[$i]['iva'] / 100);
            $arrayCli[$i]['total'] = $arrayCli[$i]['subtotal_descuento'] + $arrayCli[$i]['valor_iva'];
         }
      }

      $arrayCli = count($arrayCli) == 1 ? $arrayCli[0] : array();

      return $arrayCli;
   }

   protected function preguardar(&$bdObjeto) {
      parent::preguardar($bdObjeto);

      $request = new S3Request();

      $variablesPost = $request->obtenerVariables();
//__P($variablesPost);
      $bdObjeto->linea_id = "";
      $bdObjeto->linea_str = "";

      foreach ($variablesPost['linea'] as $k => $v) {
         $ln = explode("-", $v);
         $bdObjeto->linea_id .= $ln[0] . ((($k + 1 ) == sizeof($variablesPost['linea'])) ? ' ' : ', ');
         $bdObjeto->linea_str .= $ln[1] . ((($k + 1 ) == sizeof($variablesPost['linea'])) ? ' ' : ', ');
      }

      $bdObjeto->subtotal = str_replace(",", "", $bdObjeto->subtotal);
      $bdObjeto->descuento = str_replace(",", "", $bdObjeto->descuento);
   }

   protected function postguardar(&$bdObjeto) {
      parent::postguardar($bdObjeto);

      require_once 'modelo/Cotizacion_detalle.php';

      $request = new S3Request();
      $post = $request->obtenerVariables();

      foreach ($post['detalle_cotizacion_id'] as $k => $v) {
         $detalle = new Cotizacion_detalle();
         $detalle->guardar($bdObjeto->id, $k);
      }
      $peticion = array(
          'modulo' => 'cotizaciones',
          'accion' => 'editar',
          'parametros' => array('registro' => $bdObjeto->id)
      );

      $request->redireccionar($peticion);
      //    __P($aplicacion);
   }

   protected function postguardarModal(&$bdObjeto) {
      parent::postguardar($bdObjeto);

      require_once 'modelo/Cotizacion_detalle.php';

      $request = new S3Request();
      $post = $request->obtenerVariables();

      foreach ($post['detalle_cotizacion_id'] as $k => $v) {
         $detalle = new Cotizacion_detalle();
         $detalle->guardar($bdObjeto->id, $k);
      }
      return 1;
   }

//traer los documentos por modulo y id
   public function obtener_relacionados($parametros) {
      if ($parametros['modulo_name'] == 'oportunidades') {

         $bdObjeto = static::query()
                 ->selectRaw("cotizacion.id, cotizacion.eliminado, cotizacion.numero_factura, olm.nombre as etapa")
                 ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.etapa_id")
                 ->whereRaw('cotizacion.oportunidad_id = ' . $parametros['modulo_id'])
                 ->whereRaw('cotizacion.cuenta_id = ' . $parametros['modulo_cuenta'])
                 ->where('cotizacion.eliminado', '=', '0')
                 ->get();

         $lista = $bdObjeto->toArray();
//__P('$lista');
         $tmp = Array();
         //preformatea lo que se va a imprimir
         for ($i = 0; $i < count($lista); $i++) {
            $tmp[$i]['id'] = $lista[$i]['id'];
            $tmp[$i]['numero_factura'][] = $lista[$i]['numero_factura'];
            $tmp[$i]['etapa'][] = $lista[$i]['etapa'];
            $tmp[$i]['eliminado'] = '<i class=" fa fa-minus"></i>';
         }

         $array['campos'] = Array
             (
             '0' => Array
                 (
                 'data' => 'id',
                 'mData' => 'id'
             ),
             '1' => Array
                 (
                 'data' => 'numero_factura',
                 'mData' => 'numero_factura'
             ),
             '2' => Array
                 (
                 'data' => 'etapa',
                 'mData' => 'etapa'
             ),
             '3' => Array
                 (
                 'data' => 'eliminado',
                 'mData' => 'eliminado'
             )
         );

         $k = 0;
         $array['count_ctzcns'] = count($tmp);
         $array['ctzcns'] = $tmp;
      }




      if ($parametros['modulo_name'] == 'cuentas') {
         $bdObjeto = static::query()
                 ->selectRaw("cotizacion.id, cotizacion.eliminado, cotizacion.numero_factura, olm.nombre as etapa")
                 ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.etapa_id")
                 ->whereRaw('cotizacion.cuenta_id = ' . $parametros['modulo_id'])
                 ->where('cotizacion.eliminado', '=', '0')
                 ->get();

         $lista = $bdObjeto->toArray();
//__P('$lista');
         $tmp = Array();
         //preformatea lo que se va a imprimir
         for ($i = 0; $i < count($lista); $i++) {
            $tmp[$i]['id'] = $lista[$i]['id'];
            $tmp[$i]['numero_factura'][] = $lista[$i]['numero_factura'];
            $tmp[$i]['etapa'][] = $lista[$i]['etapa'];
            $tmp[$i]['eliminado'] = '<i class=" fa fa-minus"></i>';
         }

         $array['campos'] = Array
             (
             '0' => Array
                 (
                 'data' => 'id',
                 'mData' => 'id'
             ),
             '1' => Array
                 (
                 'data' => 'numero_factura',
                 'mData' => 'numero_factura'
             ),
             '2' => Array
                 (
                 'data' => 'etapa',
                 'mData' => 'etapa'
             ),
             '3' => Array
                 (
                 'data' => 'eliminado',
                 'mData' => 'eliminado'
             )
         );

         $k = 0;
         $array['count_ctzcns'] = count($tmp);
         $array['ctzcns'] = $tmp;
      }


      return $array;
   }

   public function enviarCorreos($parametros, $principal = true) {

      require_once 'modelo/Correo.php';
      $correo = new Correo();
      $correos = $correo->obtenerCorreoXModulo($parametros['cuenta_id'], 'cuenta');

      //obtener los correos de los usuario remitentes
      if (!empty($parametros['remitentes'])) {
         $correosUsuarios = $correo->obtenerCorreoXidUsuarios($parametros['remitentes']);
      }

      $enviado_a = array();
      //generacion del pdf para adjuntar
      require_once 'librerias/php/dompdf/crearPDF.php';
      require_once 'modulos/cotizaciones/acciones.php';
      $objAccionesCotizaciones = new AccionesCotizaciones();

      $html = $objAccionesCotizaciones->generarPlantilla($parametros['registro_id']);
      $nombreArchivo = "Cotizacion_" . $parametros['registro_id'];

      new crearPDF($html, $nombreArchivo, 'uploads/');

      $datos = array(
          'contenido' => $parametros['detalle_correo']
      );

      //Envio de mails con archivo adjunto

      $mailer = new S3Mailer();
      $mailer->asignarTplBase('modulos/plantillas_correo/correo_enviar_cotizacion');
      $mailer->asignarDatos($datos);
      $adjuntos[] = array('adjunto' => getcwd() . '/uploads/' . $nombreArchivo . ".pdf");
      $mailer->asignarAdjuntos($adjuntos);

      for ($i = 0; $i < sizeof($correos); $i++) {
         if ($principal) {
            if ($correos[$i]['principal'] == 1) {
               $result = $mailer->enviarCorreo($correos[$i]['e_mail'], "Envio Cotización");
            }
         } else {
            $result = $mailer->enviarCorreo($correos[$i]['e_mail'], "Envio Cotización");
         }
         $enviado_a[] = $correos[$i]['e_mail'];
      }

      //envio de correo por c/u de los remitentes
      for ($i = 0; $i < count($correosUsuarios); $i++) {
         $mailer->enviarCorreo($correosUsuarios[$i]['correo'], "Envio Cotización");
         $enviado_a[] = $correosUsuarios[$i]['correo'];
      }
      $enviado_a = implode('<br>', $enviado_a);

      return $enviado_a;
   }

   public function valorGanadas($oportunidad) {
      $bdObjeto = static::query()
              ->selectRaw('subtotal, descuento, olm.nombre as iva')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
              ->whereRaw('cuenta_id = ' . $oportunidad)
              ->where('cotizacion.eliminado', '=', 0)
              ->where('cotizacion.activo', '=', 1)
              ->where('cotizacion.etapa_id', '=', 46)
              ->get();

      $registro = $bdObjeto->toArray();
      //__P($registro, false);
      for ($i = 0; $i < sizeof($registro); $i++) {
         $subtotal = $registro[$i]['subtotal'] - $registro[$i]['descuento'];
         $iva = $registro[$i]['iva'];
         $valoriva = ($subtotal * ($iva / 100));
         $valorTotal += $subtotal + $valoriva;
      }
      //__P($valorTotal);
      return number_format($valorTotal);
   }

   public function obtenerGanadasXMes($parametros) {

      $bdObjeto = static::query()
              ->selectRaw('month(IFNULL(cotizacion.fecha_modificacion, cotizacion.fecha_creacion)) as mes, YEAR(cotizacion.fecha_creacion) as annio, count(cotizacion.id) as value, IFNULL(cotizacion.fecha_modificacion, cotizacion.fecha_creacion) as fecha, olm.nombre as valor_iva, sum(cotizacion.subtotal) as subtotal, sum(cotizacion.descuento) as descuento')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
              ->where('cotizacion.cuenta_id', '=', $parametros['id'])
              ->where('cotizacion.eliminado', '=', 0)
              ->where('cotizacion.activo', '=', 1)
              ->where('cotizacion.etapa_id', '=', 46)
              ->groupBy('mes')->orderBy('annio', 'DESC')->orderBy('mes', 'DESC')
              ->get();

      $fin = $parametros['mes'];
      $ini = $fin - 5;
      if ($ini < 1) {
         $ini += 12;
      }

      $lista = array_reverse($bdObjeto->toArray());
      $arrafecha = explode("-", $lista[0]['fecha']);
      if ($ini < $fin) {
         $anno = $arrafecha[0];
      } else {
         $anno = $arrafecha[0] - 1;
      }
      $registros = array();
      $pos = 0;
      while ($ini != $fin + 1) {

         if ($ini == 13) {
            $ini = 1;
            $anno++;
         }

         if (strlen($ini) == 1) {
            $mes = '0' . $ini;
         } else {
            $mes = $ini;
         }
         if (isset($lista[$pos]['mes']) && $lista[$pos]['mes'] == $ini) {
            $arrafecha = explode(" ", $lista[$pos]['fecha']);
            $lista[$pos]['fecha'] = $arrafecha[0];

            $subtotal = $lista[$pos]['subtotal'] - $lista[$pos]['descuento'];
            $iva = $lista[$pos]['valor_iva'];
            $valoriva = ($subtotal * ($iva / 100));
            $valorTotal = $subtotal + $valoriva;

            $registros[] = array(
                'value' => $lista[$pos]['value'],
                'fecha' => $lista[$pos]['fecha'],
                'mes' => (int) $mes,
                'total' => number_format($valorTotal)
            );
            $pos++;
         } else {
            $registros[] = array(
                'value' => 0,
                'fecha' => $anno . '-' . $mes . '-19',
                'mes' => (int) $mes,
                'total' => number_format(0)
            );
         }
         $ini++;
      }

      return $registros;
   }

   public function obtenerVentas() {
      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
//      __P($variablesPost);
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }

//        __P($w);
      $bdObjeto = static::query()
                      ->selectRaw('MONTH(IFNULL(cotizacion.fecha_cierre,cotizacion.fecha_creacion)) AS mes, YEAR( IFNULL(cotizacion.fecha_cierre, cotizacion.fecha_creacion)) AS annio, IFNULL(cotizacion.fecha_cierre, cotizacion.fecha_creacion ) AS fecha, ROUND( ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ) , 2 ) AS value')
                      ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
                      ->where('cotizacion.eliminado', '=', 0)
                      ->where('cotizacion.activo', '=', 1)
                      ->where('cotizacion.etapa_id', '=', 46)
                      ->whereRaw($w)
                      ->groupBy('mes')->orderBy('annio', 'ASC')->orderBy('mes', 'ASC');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
      $arrayTamano = $bdObjeto->get()->toArray();
      $j = 0;
      $mes = new S3Utils();

      for ($i = 0; $i < sizeof($arrayTamano); $i++) {
         if ($arrayCli[$i]['mes'] < 10) {
            $arrayCli[$i]['mes'] = "0" . $arrayCli[$i]['mes'];
         }
         $arrayCli[$i]['fecha'] = $arrayCli[$i]['annio'] . "-" . $arrayCli[$i]['mes'];
         $arrayCli[$i]['mes'] = $mes->obtener_nombre_mes($arrayCli[$i]['mes']);
         $arrayCli[$i]['lineColor'] = "#DB597B";
//         unset($arrayCli[$i]['mes']);
         unset($arrayCli[$i]['annio']);
         if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde']) {
               $filtrado[$j++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde'] && $arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
//        __P($variablesPost);
               $filtrado[$j++] = $arrayCli[$i];
            }
         }
      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);
         return $filtrado;
      }
//        __P($arrayCli);
      return $arrayCli;
   }

   public function obtenerMensualidadVentas() {

      $bdObjeto = static::query()
                      ->selectRaw('MONTH(IFNULL(cotizacion.fecha_cierre,cotizacion.fecha_creacion)) AS mes, YEAR( IFNULL(cotizacion.fecha_cierre, cotizacion.fecha_creacion)) AS annio, COUNT(cotizacion.id) AS numero, IFNULL(cotizacion.fecha_cierre, cotizacion.fecha_creacion ) AS fecha, ROUND( ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ) , 2 ) AS total')
                      ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
                      ->where('cotizacion.eliminado', '=', 0)
                      ->where('cotizacion.activo', '=', 1)
                      ->where('cotizacion.etapa_id', '=', 46)
                      ->whereRaw('IFNULL( MONTH(fecha_cierre) BETWEEN MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(CURDATE()), MONTH(fecha_creacion) BETWEEN MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(CURDATE()))')
                      ->groupBy('mes')->orderBy('annio', 'ASC')->orderBy('mes', 'ASC');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
if(isset($arrayCli[1])){
      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         unset($arrayCli[$i]['fecha']);
         unset($arrayCli[$i]['annio']);

      }
      $reporteMes['diferencia'] = $arrayCli[1]['total'] - $arrayCli[0]['total'];
      if ($reporteMes['diferencia'] > 0) {
         $reporteMes['indicador'] = 'true';
      } else {
         $reporteMes['indicador'] = 'false';
      }
      if ($arrayCli[1]['mes'] < 10) {
         $arrayCli[1]['mes'] = "0" . $arrayCli[1]['mes'];
      }
      $mes = new S3Utils();
      $reporteMes['mes'] = $mes->obtener_nombre_mes($arrayCli[1]['mes']);
      $reporteMes['total'] = $arrayCli[1]['total'];
      $reporteMes['cantidad'] = $arrayCli[1]['numero'];
      }
      else {
               $reporteMes['diferencia'] = $arrayCli[0]['total'];
               if ($reporteMes['diferencia'] > 0){
               $reporteMes['indicador'] = 'true';
            } else { 
               $reporteMes['indicador'] = 'false'; 
            }
            if ($arrayCli[0]['mes']<10){
               $arrayCli[0]['mes'] = "0".$arrayCli[0]['mes'];
            }
            $mes = new S3Utils();
            $reporteMes['mes'] = $mes->obtener_nombre_mes($arrayCli[0]['mes']);
            $reporteMes['total'] = $arrayCli[0]['total'];
            $reporteMes['cantidad'] = $arrayCli[0]['numero'];
            }
//      __P($reporteMes);
      $reporteMes['total'] = number_format($reporteMes['total'], 2, ',', '.');
      return $reporteMes;
   }

   public function obtenerGanadasPorAsesor() {
      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), cotizacion.fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', cotizacion.fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }
//        __P($variablesPost);
//        __P($w);
      $bdObjeto = static::query()
              ->selectRaw('  u.nombres,ROUND( ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ) , 2 ) AS value')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
              ->join("usuario as u", "cotizacion.asesor_id", "=", "u.id")
              ->where('cotizacion.eliminado', '=', 0)
              ->where('cotizacion.activo', '=', 1)
              ->where('cotizacion.etapa_id', '=', 46)
              ->whereRaw($w)
              ->groupBy('cotizacion.asesor_id');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
//            __P($arrayCli);
      $arrayTamano = $bdObjeto->get()->toArray();
      $j = 0;
      for ($i = 0; $i < sizeof($arrayTamano); $i++) {
         $arrayCli[$i]['color'] = "#022d5b";
         if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde']) {
               $filtrado[$j++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde'] && $arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
//        __P($variablesPost);
               $filtrado[$j++] = $arrayCli[$i];
            }
         }
      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);
         return $filtrado;
      }
//        __P($arrayCli);
      return $arrayCli;
   }

   public function obtenerCotizacionPorAsesor() {
      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), cotizacion.fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', cotizacion.fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }

//        __P($w);

      $bdObjeto = static::query()
              ->selectRaw('  u.nombres, ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ) AS value')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
              ->join("usuario as u", "cotizacion.asesor_id", "=", "u.id")
              ->where('cotizacion.eliminado', '=', 0)
              ->where('cotizacion.activo', '=', 1)
              ->whereRaw($w)
              ->groupBy('cotizacion.asesor_id');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
//            __P($arrayCli);
      $arrayTamano = $bdObjeto->get()->toArray();
      $j = 0;
      for ($i = 0; $i < sizeof($arrayTamano); $i++) {
         $arrayCli[$i]['color'] = "#53D4D6";
         if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde']) {
               $filtrado[$j++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde'] && $arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
//        __P($variablesPost);
               $filtrado[$j++] = $arrayCli[$i];
            }
         }
      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);
         return $filtrado;
      }
//        __P($arrayCli);
      return $arrayCli;
   }

   public function obtenerMensualidadCotizacion() {

      $bdObjeto = static::query()
                      ->selectRaw('MONTH(IFNULL(cotizacion.fecha_cierre,cotizacion.fecha_creacion)) AS mes, YEAR( IFNULL(cotizacion.fecha_cierre, cotizacion.fecha_creacion)) AS annio, COUNT(cotizacion.id) AS numero, IFNULL(cotizacion.fecha_cierre, cotizacion.fecha_creacion ) AS fecha, ROUND( ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ) , 2 ) AS total')
                      ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
                      ->where('cotizacion.eliminado', '=', 0)
                      ->where('cotizacion.activo', '=', 1)
                      ->whereRaw('IFNULL( MONTH(fecha_cierre) BETWEEN MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(CURDATE()), MONTH(fecha_creacion) BETWEEN MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(CURDATE()))')
                      ->groupBy('mes')->orderBy('annio', 'ASC')->orderBy('mes', 'ASC');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
if(isset($arrayCli[1])){
      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         unset($arrayCli[$i]['fecha']);
         unset($arrayCli[$i]['annio']);

      }
      $reporteMes['diferencia'] = $arrayCli[1]['total'] - $arrayCli[0]['total'];
      if ($reporteMes['diferencia'] > 0) {
         $reporteMes['indicador'] = 'true';
      } else {
         $reporteMes['indicador'] = 'false';
      }
      if ($arrayCli[1]['mes'] < 10) {
         $arrayCli[1]['mes'] = "0" . $arrayCli[1]['mes'];
      }
      $mes = new S3Utils();
      $reporteMes['mes'] = $mes->obtener_nombre_mes($arrayCli[1]['mes']);
      $reporteMes['total'] = $arrayCli[1]['total'];
      $reporteMes['cantidad'] = $arrayCli[1]['numero'];
      }
      else {
               $reporteMes['diferencia'] = $arrayCli[0]['total'];
               if ($reporteMes['diferencia'] > 0){
               $reporteMes['indicador'] = 'true';
            } else { 
               $reporteMes['indicador'] = 'false'; 
            }
            if ($arrayCli[0]['mes']<10){
               $arrayCli[0]['mes'] = "0".$arrayCli[0]['mes'];
            }
            $mes = new S3Utils();
            $reporteMes['mes'] = $mes->obtener_nombre_mes($arrayCli[0]['mes']);
            $reporteMes['total'] = $arrayCli[0]['total'];
            $reporteMes['cantidad'] = $arrayCli[0]['numero'];
            }
//      __P($reporteMes);
      $reporteMes['total'] = number_format($reporteMes['total'], 2, ',', '.');
      return $reporteMes;
   }

   public function obtenerVentaLineaNegocio() {
      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
//        __P($variablesPost);
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), cotizacion.fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', cotizacion.fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }


      $bdObjeto = static::query()
              ->selectRaw('olmL.id AS opcion,COUNT(cotizacion.id) AS cantidad,  ROUND( ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ) , 2 ) AS value, olmL.nombre AS title')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
              ->join("opcion_lista_maestra as olmL", "olmL.id", "=", "cotizacion.linea_id")
              ->where('cotizacion.eliminado', '=', 0)
              ->where('cotizacion.activo', '=', 1)
              ->where('cotizacion.etapa_id', '=', 46)
              ->whereRaw($w)
              ->groupBy('title');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
//            __P($arrayCli);
      $arrayTamano = $bdObjeto->get()->toArray();
      $j = 0;
      for ($i = 0; $i < sizeof($arrayTamano); $i++) {
         if ($arrayCli[$i]['opcion'] == '75') {
            $arrayCli[$i]['color'] = "#E7687F";
         }
         if ($arrayCli[$i]['opcion'] == '71') {
            $arrayCli[$i]['color'] = "#EEBD4E";
         }
         if ($arrayCli[$i]['opcion'] == '72') {
            $arrayCli[$i]['color'] = "#00D1C0";
         }
         if ($arrayCli[$i]['opcion'] == '73') {
            $arrayCli[$i]['color'] = "#1298C7";
         }
         if ($arrayCli[$i]['opcion'] == '74') {
            $arrayCli[$i]['color'] = "#8BB543";
         }
         if ($arrayCli[$i]['opcion'] == 'Alquiler Permanente') {
            $arrayCli[$i]['color'] = "#e24f4f";
         }
         unset($arrayCli[$i]['opcion']);
         if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde']) {
               $filtrado[$j++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde'] && $arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
//        __P($variablesPost
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);
         return $filtrado;
      }
//        __P($arrayCli);
      return $arrayCli;
   }

   public function obtenerCotizacionLineaNegocio() {

      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
//        __P($variablesPost);
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), cotizacion.fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', cotizacion.fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }

      $bdObjeto = static::query()
              ->selectRaw('olmL.id AS opcion,COUNT(cotizacion.id) AS cantidad, ROUND( ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ), 2 ) AS value, olmL.nombre AS title')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
              ->join("opcion_lista_maestra as olmL", "olmL.id", "=", "cotizacion.linea_id")
              ->where('cotizacion.eliminado', '=', 0)
              ->where('cotizacion.activo', '=', 1)
              ->whereRaw($w)
              ->groupBy('title');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
//            __P($arrayCli);
      $arrayTamano = $bdObjeto->get()->toArray();
      $j = 0;
      for ($i = 0; $i < sizeof($arrayTamano); $i++) {
         if ($arrayCli[$i]['opcion'] == '75') {
            $arrayCli[$i]['color'] = "#E7687F";
         }
         if ($arrayCli[$i]['opcion'] == '71') {
            $arrayCli[$i]['color'] = "#EEBD4E";
         }
         if ($arrayCli[$i]['opcion'] == '72') {
            $arrayCli[$i]['color'] = "#00D1C0";
         }
         if ($arrayCli[$i]['opcion'] == '73') {
            $arrayCli[$i]['color'] = "#1298C7";
         }
         if ($arrayCli[$i]['opcion'] == '74') {
            $arrayCli[$i]['color'] = "#8BB543";
         }
         if ($arrayCli[$i]['opcion'] == 'Alquiler Permanente') {
            $arrayCli[$i]['color'] = "#e24f4f";
         }         
         unset($arrayCli[$i]['opcion']);
         
         if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde']) {
               $filtrado[$j++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde'] && $arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
//        __P($variablesPost);
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);
         return $filtrado;
      }
//        __P($arrayCli);
      return $arrayCli;
   }

   public function obtenerCotizacionEtapa() {

      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
//        __P($variablesPost);
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), cotizacion.fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', cotizacion.fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }

      $bdObjeto = static::query()
              ->selectRaw('olmE.id AS opcion, ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ) AS value, olmE.nombre AS etapa ')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
              ->join("opcion_lista_maestra as olmE", "olmE.id", "=", "cotizacion.etapa_id")
              ->where('cotizacion.eliminado', '=', 0)
              ->where('cotizacion.activo', '=', 1)
              ->whereRaw($w)
              ->groupBy('etapa');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
//            __P($arrayCli);
      $j = 0;
      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         if ($arrayCli[$i]['opcion'] == '22') {
            $arrayCli[$i]['color'] = "#1298c7";
         }
         if ($arrayCli[$i]['opcion'] == '23') {
            $arrayCli[$i]['color'] = "#097cef";
         }
         if ($arrayCli[$i]['opcion'] == '46') {
            $arrayCli[$i]['color'] = "#2fbab7";
         }
         if ($arrayCli[$i]['opcion'] == '24') {
            $arrayCli[$i]['color'] = "#74ef09";
         }
         if ($arrayCli[$i]['opcion'] == '276') {
            $arrayCli[$i]['color'] = "#eebd4e";
         }
         if ($arrayCli[$i]['opcion'] == '51') {
            $arrayCli[$i]['color'] = "#e7687f";
         }
         unset($arrayCli[$i]['opcion']);
      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde']) {
               $filtrado[$j++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde'] && $arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
//        __P($variablesPost);
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);
         return $filtrado;
      }
//        __P($arrayCli);
      return $arrayCli;
   }
   
   public function obtenerVentaSector() {

      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
//        __P($variablesPost);
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), cotizacion.fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', cotizacion.fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }

      $bdObjeto = static::query()
              ->selectRaw('olmS.id AS opcion , ROUND( ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ) , 2 ) AS value, olmS.nombre AS title')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
              ->join("cuenta as cta", "cta.id", "=", "cotizacion.cuenta_id")
              ->join("opcion_lista_maestra as olmS", "olmS.id", "=", "cta.segmento_id")
              ->where('cotizacion.eliminado', '=', 0)
              ->where('cotizacion.activo', '=', 1)
              ->where('cotizacion.etapa_id', '=', 46)
              ->whereRaw($w)
              ->groupBy('title');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
//            __P($arrayCli);
     
      $j = 0;
      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         if ($arrayCli[$i]['opcion'] == '267') {
            $arrayCli[$i]['color'] = "#eebd4e";
         }
         if ($arrayCli[$i]['opcion'] == '268') {
            $arrayCli[$i]['color'] = "#00d1c0";
         }
         if ($arrayCli[$i]['opcion'] == '269') {
            $arrayCli[$i]['color'] = "#1298c7";
         }
         if ($arrayCli[$i]['opcion'] == '270') {
            $arrayCli[$i]['color'] = "#e7687f";
         }
         unset($arrayCli[$i]['opcion']);
        if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['total'] > $variablesPost['rango_desde']) {
               $filtrado[$j++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['total'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['total'] > $variablesPost['rango_desde'] && $arrayCli[$i]['total'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);

         return $filtrado;
      }
//        __P($arrayCli);

      return $arrayCli;
   }

   public function obtenerCotizacionSector() {

      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
//        __P($variablesPost);
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), cotizacion.fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', cotizacion.fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }

      $bdObjeto = static::query()
              ->selectRaw('olmS.id AS opcion , ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ) AS value, olmS.nombre AS title')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
              ->join("cuenta as cta", "cta.id", "=", "cotizacion.cuenta_id")
              ->join("opcion_lista_maestra as olmS", "olmS.id", "=", "cta.segmento_id")
              ->where('cotizacion.eliminado', '=', 0)
              ->where('cotizacion.activo', '=', 1)
              ->whereRaw($w)
              ->groupBy('title');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
//            __P($arrayCli);
     
      $j = 0;
      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         if ($arrayCli[$i]['opcion'] == '267') {
            $arrayCli[$i]['color'] = "#eebd4e";
         }
         if ($arrayCli[$i]['opcion'] == '268') {
            $arrayCli[$i]['color'] = "#00d1c0";
         }
         if ($arrayCli[$i]['opcion'] == '269') {
            $arrayCli[$i]['color'] = "#1298c7";
         }
         if ($arrayCli[$i]['opcion'] == '270') {
            $arrayCli[$i]['color'] = "#e7687f";
         }
         unset($arrayCli[$i]['opcion']);
        if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde']) {
               $filtrado[$j++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['value'] > $variablesPost['rango_desde'] && $arrayCli[$i]['total'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);

         return $filtrado;
      }
//        __P($arrayCli);

      return $arrayCli;
   }

   public function obtenerVentaTop() {
      
      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
//        __P($variablesPost);
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), cotizacion.fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', cotizacion.fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }

      $bdObjeto = static::query()
                      ->selectRaw('COUNT(cotizacion.id) AS cantidad, IFNULL( cta.nombre_comercial, CONCAT(cta.nombres," ", cta.apellidos) ) AS nombre, (((subtotal-descuento)+((subtotal-descuento)*(olm.nombre/100)))/1000) AS total, cta.id AS cuenta , cta.avatar as imagen')
                      ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
                      ->join("cuenta as cta", "cta.id", "=", "cotizacion.cuenta_id")
                      ->where('cotizacion.eliminado', '=', 0)
                      ->where('cotizacion.activo', '=', 1)
                      ->where('cotizacion.etapa_id', '=', 46)
                      ->whereRaw($w)
                      ->groupBy('cuenta')->orderBy('total', 'DESC');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
      $j = 0;
      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         unset($arrayCli[$i]['cuenta']);
               if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['total'] > $variablesPost['rango_desde']) {
               $filtrado[$j++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['total'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['total'] > $variablesPost['rango_desde'] && $arrayCli[$i]['total'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);
          for ($i = 0; $i < sizeof($filtrado); $i++) {
               $filtrado[$i]['total'] = number_format($filtrado[$i]['total'], 2, ',', '.');
         }
         return $filtrado;
      }
//        __P($arrayCli);
      for ($i = 0; $i < sizeof($arrayCli); $i++) {
               $arrayCli[$i]['total'] = number_format($arrayCli[$i]['total'], 2, ',', '.');
         }
      return $arrayCli;
   }

   public function obtenerCotizacionPorMes() {

      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
//        __P($variablesPost);
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), cotizacion.fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', cotizacion.fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }

      $bdObjeto = static::query()
                      ->selectRaw('MONTH(IFNULL( cotizacion.fecha_cierre, cotizacion.fecha_creacion ) ) AS mes, YEAR(  IFNULL( cotizacion.fecha_cierre, cotizacion.fecha_creacion ) ) AS annio, IFNULL( cotizacion.fecha_cierre, cotizacion.fecha_creacion ) AS fecha, olmE.nombre AS etapa, ( ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) + ( ( SUM(cotizacion.subtotal) - SUM(cotizacion.descuento) ) * (olm.nombre / 100) ) ) / 1000 ) AS total')
                      ->join("opcion_lista_maestra as olm", "olm.id", "=", "cotizacion.iva")
                      ->join("opcion_lista_maestra as olmE", "olmE.id", "=", "cotizacion.etapa_id")
                      ->where('cotizacion.eliminado', '=', 0)
                      ->where('cotizacion.activo', '=', 1)
                      ->whereRaw($w)
                      ->groupBy('mes')->groupBy('etapa')->orderBy('annio', 'ASC')->orderBy('mes', 'ASC');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();

      $k = 0;
      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         unset($arrayCli[$i]['cuenta']);
         if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['total'] > $variablesPost['rango_desde']) {
               $filtrado[$k++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['total'] < $variablesPost['rango_hasta']) {
               $filtrado[$k++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['total'] > $variablesPost['rango_desde'] && $arrayCli[$i]['total'] < $variablesPost['rango_hasta']) {
               $filtrado[$k++] = $arrayCli[$i];
            }
         }
      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);
//         for ($i = 0; $i < sizeof($filtrado); $i++) {
//            $filtrado[$i]['total'] = number_format($filtrado[$i]['total'], 2, ',', '.');
//         }
         $data = array();
         $mes = new S3Utils();
         $j = -1;
         for ($i = 0; $i < sizeof($filtrado); $i++) {
            if ($filtrado[$i]['mes'] < 10) {
               $filtrado[$i]['mes'] = "0" . $filtrado[$i]['mes'];
            }
            $filtrado[$i]['mes'] = $mes->obtener_nombre_mes($filtrado[$i]['mes']);
            if ($data[$j]['mes'] === $filtrado[$i]['mes']) {
               $data[$j][$filtrado[$i]['etapa']] = $filtrado[$i]['total'];
            } else {
               $data[++$j]['mes'] = $filtrado[$i]['mes'];
               $data[$j][$filtrado[$i]['etapa']] = $filtrado[$i]['total'];
            }
         }
//        __P($data);
         return $data;
      }
//        __P($arrayCli);
//      for ($i = 0; $i < sizeof($arrayCli); $i++) {
//         $arrayCli[$i]['total'] = number_format($arrayCli[$i]['total'], 2, ',', '.');
//      }
      $data = array();
      $mes = new S3Utils();
      $j = -1;
      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         unset($arrayCli[$i]['cuenta']);
         if ($arrayCli[$i]['mes'] < 10) {
            $arrayCli[$i]['mes'] = "0" . $arrayCli[$i]['mes'];
         }
         $arrayCli[$i]['mes'] = $mes->obtener_nombre_mes($arrayCli[$i]['mes']);
         if ($data[$j]['mes'] === $arrayCli[$i]['mes']) {
            $data[$j][$arrayCli[$i]['etapa']] = $arrayCli[$i]['total'];
         } else {
            $data[++$j]['mes'] = $arrayCli[$i]['mes'];
            $data[$j][$arrayCli[$i]['etapa']] = $arrayCli[$i]['total'];
         }
      }
//        __P($data);
      return $data;
   }

   public function obtenerVentaPorProducto() {
      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      if (isset($variablesPost['conRango'])) {
         if($variablesPost['rango'] == '')
         {
         $variablesPost['rango_desde'] = 1; 
         $variablesPost['rango_hasta'] = 100000;
         }
         else
         {
         $rango=explode(",", $variablesPost['rango']);
         $variablesPost['rango_desde'] = $rango[0]; 
         $variablesPost['rango_hasta'] = $rango[1];
         }
      }
//        __P($variablesPost);
      $w = 'IFNULL(cotizacion.fecha_cierre BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE(), cotizacion.fecha_creacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE())';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
      $w = "IFNULL(cotizacion.fecha_cierre BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "', cotizacion.fecha_creacion BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "')";
      }

      $config = Spyc::YAMLLoad('modulos/reportes/config.yml');
      $producto_id = $config['reporte']['producto_venta'];
      $bdObjeto = static::query()
                      ->selectRaw('MONTH( IFNULL( cotizacion.fecha_cierre, cotizacion.fecha_creacion ) ) AS mes, YEAR( IFNULL( cotizacion.fecha_cierre, cotizacion.fecha_creacion ) ) AS annio, p.referencia AS producto, (SUM(dc.`valor_unitario`)/1000) AS total')
                      ->join("detalle_cotizacion as dc", "dc.cotizacion_id", "=", "cotizacion.id")
                      ->join("producto as p", "p.id", "=", "dc.producto_id")
                      ->where('cotizacion.eliminado', '=', 0)
                      ->where('cotizacion.activo', '=', 1)
                      ->where('cotizacion.etapa_id', '=', 46)
                      ->where('dc.producto_id', '=', $producto_id)
                      ->whereRaw($w)
                      ->groupBy('mes')->groupBy('producto')->orderBy('annio', 'ASC')->orderBy('mes', 'ASC');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
//            __P($arrayCli);
      $j = 0;

      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         if ($arrayCli[$i]['mes'] < 10) {
            $arrayCli[$i]['mes'] = "0" . $arrayCli[$i]['mes'];
         }
         $mes = new S3Utils();
         $arrayCli[$i]['mes'] = $mes->obtener_nombre_mes($arrayCli[$i]['mes']);
         $arrayCli[$i]['color'] = "#DB597B";
         unset($arrayCli[$i]['annio']);
         unset($arrayCli[$i]['producto']);
               if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' && $variablesPost['rango_hasta'] === '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            if ($arrayCli[$i]['total'] > $variablesPost['rango_desde']) {
               $filtrado[$j++] = $arrayCli[$i];
//                            __P($arrayCli);
            }
         }
         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && $variablesPost['rango_desde'] === '') {
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['total'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

         if (isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '' && isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '') {
            $variablesPost['rango_desde'] = str_replace(",", "", $variablesPost['rango_desde']);
            $variablesPost['rango_hasta'] = str_replace(",", "", $variablesPost['rango_hasta']);
            if ($arrayCli[$i]['total'] > $variablesPost['rango_desde'] && $arrayCli[$i]['total'] < $variablesPost['rango_hasta']) {
               $filtrado[$j++] = $arrayCli[$i];
            }
         }

      }

      if (isset($variablesPost['rango_desde']) && $variablesPost['rango_desde'] !== '' || isset($variablesPost['rango_hasta']) && $variablesPost['rango_hasta'] !== '') {
//        __P($filtrado);
         return $filtrado;
      }
//        __P($arrayCli);
      return $arrayCli;
   }

   protected function obtenerListaRegistrosAjaxTablaAux(&$bdObjeto, $filtro) {

      require_once 'Filtro.php';
   }

   public function guardarCotizacion() {
      global $aplicacion;
      $this->cargarCampos();

      $request = new S3Request();
      $variablesPost = $request->obtenerVariables();
      $bdObjeto = $this;


      foreach ($variablesPost as $variablePost => $valorPost) {
         if (in_array($variablePost, $this->camposTabla)) {
            $bdObjeto->$variablePost = (empty($valorPost)) ? NULL : $valorPost;
         }
      }

      if (!empty($bdObjeto) && $bdObjeto->id > 0) {
         if (in_array('actualizado_por', $this->camposTabla)) {
            $bdObjeto->actualizado_por = $aplicacion->getUsuario()->getId();
         }
         if (in_array('fecha_modificacion', $this->camposTabla)) {
            $bdObjeto->fecha_modificacion = date('Y-m-d H:i:s');
         }

         $this->preguardar($bdObjeto);
         $bdObjeto->save();
         $this->postguardar($bdObjeto);
      } else {

         if (in_array('creado_por', $this->camposTabla)) {
            $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
         }
         if (in_array('fecha_creacion', $this->camposTabla)) {

            $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
         }

         $this->preguardar($bdObjeto);
         $bdObjeto->save();
//      __P($bdObjeto);

         $this->postguardarModal($bdObjeto);
      }
   }

}
