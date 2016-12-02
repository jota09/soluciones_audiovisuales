<?php

if (!defined('s3_entrada') || !s3_entrada) {
   die('No es un punto de entrada valido');
}

class Servicio extends S3TablaBD {

   protected $table = 'servicio';

   public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

      $this->cargarCampos();
      $bdObjeto = static::query()
              ->leftjoin('cuenta AS cta', 'cta.id', '=', 'servicio.cuenta_id')
              //->where('cliente.eliminado', '=', '0')
              ->selectRaw("servicio.id, TRIM(CONCAT(IFNULL(cta.nombres,cta.nombre_comercial),' ',IFNULL(cta.apellidos,''))) AS cuenta, servicio.tipo_servicio_str AS 'servicios', servicio.activo ");

      foreach ($where AS $w) {

         if (in_array($w['columna'], $this->camposTabla)) {
            $bdObjeto->where($this->table . '.' . $w['columna'], $w['condicional'], $w['valor']);
         }
      }

      if ($ajaxTabla) {
         $this->obtenerListaRegistrosAjaxTabla($bdObjeto);
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

   protected function preguardar(&$bdObjeto) {
      parent::preguardar($bdObjeto);

      $request = new S3Request();

      $variablesPost = $request->obtenerVariables();

      $bdObjeto->linea_id = "";
      $bdObjeto->linea_str = "";
      $bdObjeto->tipo_servicio_id = "";
      $bdObjeto->tipo_servicio_str = "";

      foreach ($variablesPost['linea'] as $k => $v) {
         $ln = explode("-", $v);
         $bdObjeto->linea_id .= $ln[0] . ((($k + 1 ) == sizeof($variablesPost['linea'])) ? ' ' : ', ');
         $bdObjeto->linea_str .= $ln[1] . ((($k + 1 ) == sizeof($variablesPost['linea'])) ? ' ' : ', ');
      }

      foreach ($variablesPost['tipo_servicio'] as $k => $v) {
         $ln = explode("-", $v);
         $bdObjeto->tipo_servicio_id .= $ln[0] . ((($k + 1 ) == sizeof($variablesPost['tipo_servicio'])) ? ' ' : ', ');
         $bdObjeto->tipo_servicio_str .= $ln[1] . ((($k + 1 ) == sizeof($variablesPost['tipo_servicio'])) ? ' ' : ', ');
      }
   }

   //traer los documentos por modulo y id
   public function obtener_relacionados($parametros) {
      if ($parametros['modulo_name'] == 'cuentas') {

         $bdObjeto = static::query()
                 ->selectRaw('servicio.*')
                 ->where('servicio.cuenta_id', '=', $parametros['modulo_id'])
                 ->where('servicio.eliminado', '=', 0)
                 ->where('servicio.activo', '=', 1)
                 ->get();
      }

      $lista = $bdObjeto->toArray();
      $tmp = Array();
      //preformatea lo que se va a imprimir
      for ($i = 0; $i < count($lista); $i++) {
         $tmp[$i]['id'] = $lista[$i]['id'];
         $tmp[$i]['fecha_vigencia_desde'][] = $lista[$i]['fecha_vigencia_desde'];
         $tmp[$i]['fecha_vigencia_hasta'][] = $lista[$i]['fecha_vigencia_hasta'];
         $tmp[$i]['tipo_servicio_str'][] = $lista[$i]['tipo_servicio_str'];
         $tmp[$i]['valor_servicio'][] = $lista[$i]['valor_servicio'];
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
              'data' => 'tipo_servicio_str',
              'mData' => 'tipo_servicio_str'
          ),
          '2' => Array
              (
              'data' => 'fecha_vigencia_desde',
              'mData' => 'fecha_vigencia_desde'
          ),
          '3' => Array
              (
              'data' => 'fecha_vigencia_hasta',
              'mData' => 'fecha_vigencia_hasta'
          ),
          '4' => Array
              (
              'data' => 'valor_servicio',
              'mData' => 'valor_servicio'
          ),
          '5' => Array
              (
              'data' => 'eliminado',
              'mData' => 'eliminado'
          )
      );

      $array['count_serv'] = count($tmp);
      $array['serv'] = $tmp;

      return $array;
   }

   public function obtenerServicio() {
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
      $w = 'sp.fecha_pago BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "sp.fecha_pago BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "'";
      }

//        __P($w);
      $bdObjeto = static::query()
              ->selectRaw('olm.nombre AS servicio, MONTH(sp.fecha_pago) AS mes, YEAR(sp.fecha_pago) AS annio, (SUM(sp.`valor`)/1000) AS value')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "servicio.tipo_servicio_id")
              ->join("servicio_pago AS sp", "sp.servicio_id", "=", "servicio.id")
              ->where('servicio.eliminado', '=', 0)
              ->where('servicio.activo', '=', 1)
              ->where('sp.eliminado', '=', 0)
              ->whereRaw($w)
              ->groupBy('servicio');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
//            __P($arrayCli);

      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         $arrayCli[$i]['color'] = "#edde10";
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

   public function obtenerMensualidadServicio() {

      $bdObjeto = static::query()
                      ->selectRaw('MONTH(sp.fecha_pago) AS mes, YEAR(sp.fecha_pago) AS annio, COUNT(DISTINCT servicio.id) AS numero, sp.fecha_pago AS fecha, (SUM(sp.valor))/1000 AS total')
                      ->join("servicio_pago AS sp", "sp.servicio_id", "=", "servicio.id")
                      ->where('servicio.eliminado', '=', 0)
                      ->where('servicio.activo', '=', 1)
                      ->whereRaw('MONTH(sp.fecha_pago) BETWEEN MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(CURDATE())')
                      ->groupBy('mes')->orderBy('annio', 'ASC')->orderBy('mes', 'ASC');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
      if (isset($arrayCli[1])) {
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
      } else {
         $reporteMes['diferencia'] = $arrayCli[0]['total'];
         if ($reporteMes['diferencia'] > 0) {
            $reporteMes['indicador'] = 'true';
         } else {
            $reporteMes['indicador'] = 'false';
         }
         if ($arrayCli[0]['mes'] < 10) {
            $arrayCli[0]['mes'] = "0" . $arrayCli[0]['mes'];
         }
         $mes = new S3Utils();
         $reporteMes['mes'] = $mes->obtener_nombre_mes($arrayCli[0]['mes']);
         $reporteMes['total'] = $arrayCli[0]['total'];
         $reporteMes['cantidad'] = $arrayCli[0]['numero'];
      }
      $reporteMes['total'] = number_format($reporteMes['total'], 2, ',', '.');

//            __P($reporteMes);
      return $reporteMes;
   }

   public function obtenerServicioLineaNegocio() {
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
      $w = 'sp.fecha_pago BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "sp.fecha_pago BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "'";
      }
//        __P($variablesPost);
      $bdObjeto = static::query()
              ->selectRaw('olm.id AS opcion , olm.nombre AS linea, ROUND((SUM(sp.`valor`) / 1000) , 2 ) AS value')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "servicio.tipo_servicio_id")
              ->join("servicio_pago AS sp", "sp.servicio_id", "=", "servicio.id")
              ->where('servicio.eliminado', '=', 0)
              ->where('servicio.activo', '=', 1)
              ->where('sp.eliminado', '=', 0)
              ->whereRaw($w)
              ->groupBy('servicio.id');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
      $j = 0;

      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         if ($arrayCli[$i]['opcion'] == '70') {
            $arrayCli[$i]['color'] = "#E7687F";
         }
         if ($arrayCli[$i]['opcion'] == '67') {
            $arrayCli[$i]['color'] = "#EEBD4E";
         }
         if ($arrayCli[$i]['opcion'] == '68') {
            $arrayCli[$i]['color'] = "#00D1C0";
         }
         if ($arrayCli[$i]['opcion'] == '69') {
            $arrayCli[$i]['color'] = "#1298C7";
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

   public function obtenerServicioEstado() {
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
      $w = 'sp.fecha_pago BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "sp.fecha_pago BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "'";
      }
//        __P($variablesPost);
      $bdObjeto = static::query()
              ->selectRaw('olm.nombre AS estado, ROUND (SUM(sp.valor) / 1000, 2 ) AS value')
              ->join("opcion_lista_maestra as olm", "olm.id", "=", "servicio.estado_servicio_id")
              ->join("servicio_pago AS sp", "sp.servicio_id", "=", "servicio.id")
              ->where('servicio.eliminado', '=', 0)
              ->where('servicio.activo', '=', 1)
              ->where('sp.eliminado', '=', 0)
              ->whereRaw($w)
              ->groupBy('estado');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
//            __P($arrayCli);
      $j = 0;
      for ($i = 0; $i < sizeof($arrayCli); $i++) {

         if ($arrayCli[$i]['estado'] == 'Activo') {
            $arrayCli[$i]['color'] = "#09efe4";
         }
         if ($arrayCli[$i]['estado'] == 'Retirado') {
            $arrayCli[$i]['color'] = "#edde10";
         }
         if ($arrayCli[$i]['estado'] == 'Suspendido') {
            $arrayCli[$i]['color'] = "#fc5d95";
         }

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

   public function obtenerIngresoPorServicio() {

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
      $w = 'sp.fecha_pago BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()';
      if (isset($variablesPost['fecha_desde']) && $variablesPost['fecha_desde'] !== '') {
         $w = "sp.fecha_pago BETWEEN '" . $variablesPost['fecha_desde'] . "' AND '" . $variablesPost['fecha_hasta'] . "'";
      }

//        __P($variablesPost);
      $bdObjeto = static::query()
                      ->selectRaw('MONTH(sp.fecha_pago) AS mes, YEAR(sp.fecha_pago) AS annio, ROUND (SUM(sp.valor) / 1000, 2 ) AS value')
                      ->join("servicio_pago AS sp", "sp.servicio_id", "=", "servicio.id")
                      ->where('servicio.eliminado', '=', 0)
                      ->where('servicio.activo', '=', 1)
                      ->whereRaw($w)
                      ->groupBy('mes')->orderBy('annio', 'ASC')->orderBy('mes', 'ASC');
//        __P($bdObjeto->toSql());
      $arrayCli = $bdObjeto->get()->toArray();
      $j = 0;

      for ($i = 0; $i < sizeof($arrayCli); $i++) {
         if ($arrayCli[$i]['mes'] < 10) {
            $arrayCli[$i]['mes'] = "0" . $arrayCli[$i]['mes'];
         }
         $arrayCli[$i]['fecha'] = $arrayCli[$i]['annio'] . "-" . $arrayCli[$i]['mes'] . "-15";
         $arrayCli[$i]['lineColor'] = "#c6ba0d";
         unset($arrayCli[$i]['mes']);
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

   protected function postguardar(&$bdObjeto) {
      require_once 'modelo/Servicio_pago.php';

      $request = new S3Request();
      $post = $request->obtenerVariables();
//    __P($post);
      foreach ($post['pago_id'] as $k => $v) {
         $pago = new Servicio_pago();
         $pago->guardar($bdObjeto->id, $k);
      }
   }

}
