<?php

if (!defined('s3_entrada') || !s3_entrada) {
      die('No es un punto de entrada valido');
}

class Caso extends S3TablaBD {

      protected $table = 'caso';
      
      public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

    $this->cargarCampos();
    $bdObjeto = static::query()
            ->leftjoin('opcion_lista_maestra AS olm_t', 'olm_t.id', '=', 'caso.tipo_id')
            ->leftjoin('cuenta AS cta', 'cta.id', '=', 'caso.cuenta_id')
            ->leftjoin('opcion_lista_maestra AS olm_e', 'olm_e.id', '=', 'caso.estado_id')
            ->leftjoin('opcion_lista_maestra AS olm_o', 'olm_o.id', '=', 'caso.origen_id')
            ->leftjoin('usuario AS us', 'us.id', '=', 'caso.asesor_asignado_id')
            ->leftjoin('opcion_lista_maestra AS olm_p', 'olm_p.id', '=', 'caso.prioridad_id')
            ->leftjoin('servicio AS ser', 'ser.id', '=', 'caso.servicio_id')
            ->selectRaw("caso.id ,olm_t.nombre as tipo, TRIM(CONCAT(IFNULL(cta.nombres,cta.nombre_comercial),' ',IFNULL(cta.apellidos,''))) AS cuenta, olm_e.nombre  AS estado,  olm_o.nombre as origen, CONCAT(us.nombres,' ',us.apellidos) as asesor, caso.numero, olm_p.nombre as prioridad, ser.tipo_servicio_str as servicios , caso.activo ");

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
            if (!$bdObjeto->id > 0) {
                  require_once 'librerias/php/Generar_autonumeracion.php';
                  $prefijo = 'CSS';

                  $objGenerar_autonumeracion = new Generar_autonumeracion($this->table, 'numero', $prefijo, '-', 5);
                  $bdObjeto->numero = $objGenerar_autonumeracion->segunda_forma();
            }
      }

      public function misCasos() {
            global $aplicacion;
            return static::query()
                            ->selectRaw('caso.*,estado_rel.nombre AS estado_nombre,prioridad.nombre prioridad')
                            ->limit(3)
                            ->leftjoin('opcion_lista_maestra as estado_rel', 'estado_rel.id', '=', 'caso.estado_id')
                            ->leftjoin('opcion_lista_maestra as prioridad', 'prioridad.id', '=', 'caso.prioridad_id')
                            ->where('caso.creado_por', '=', $aplicacion->getUsuario()->getID())
                            ->where('caso.eliminado', '=', 0)
                            ->orderBy('caso.id', 'DESC')
                            ->get()->toArray();
      }

      protected function prelistar(&$bdObjeto) {
       
      $request = new S3Request();
      $post = $request->obtenerVariables();
          $this->cargarCampos();

//      __P($bdObjeto);
      if (isset($post['search']['value']) && $post['search']['value'] != '') {
         $where = '(';
         foreach ($this->camposTabla AS $c) {
            if (preg_match('/./', $c)) {
               $tmpC = explode('.', $c);
               $c = implode('`.`', $tmpC);
            }

            $where .= '`' . $this->table . '`.`' . $c . '` LIKE "%' . $post['search']['value'] . '%" OR ';
         }

         $whereAux = substr($where, 0, -4) . ')';
         $bdObjeto->whereRaw($whereAux);
//      __P($whereAux);

       }
       
        $tmpObj = clone $bdObjeto;
        $this->cantFil = $tmpObj->count();

      $this->modObtenerListaRegistrosAjaxTabla($bdObjeto);
//      __P($bdObjeto);
      $bdObjeto->take($post['length'])->skip($post['start']);
  }

      public function analiticaCasos($acuerdoId) {

            $bdObjeto = static::query()
                    ->selectRaw("caso.*")
                    ->whereRaw("caso.servicio_id  = " . $acuerdoId)
                    ->where('caso.activo', '=', 1)
                    ->where('caso.eliminado', '=', 0)
                    ->count();
            return $bdObjeto;
      }

      //traer los documentos por modulo y id
      public function obtener_relacionados($parametros) {

            if ($parametros['modulo_name'] == 'servicios') {

                  $bdObjeto = static::query()
                          ->selectRaw('caso.*, olm.nombre as tipo, olm1.nombre as estado')
                          ->join("opcion_lista_maestra as olm", "olm.id", "=", "caso.tipo_id")
                          ->join("opcion_lista_maestra as olm1", "olm1.id", "=", "caso.estado_id")
                          ->whereRaw("caso.servicio_id  = " . $parametros['modulo_id'])
                          ->where('caso.eliminado', '=', 0)
                          ->where('caso.activo', '=', 1)
                          ->get();
            }
            if ($parametros['modulo_name'] == 'cuentas') {

                  $bdObjeto = static::query()
                          ->selectRaw('caso.*, olm.nombre as tipo, olm1.nombre as estado')
                          ->join("opcion_lista_maestra as olm", "olm.id", "=", "caso.tipo_id")
                          ->join("opcion_lista_maestra as olm1", "olm1.id", "=", "caso.estado_id")
                          ->whereRaw("caso.cuenta_id  = " . $parametros['modulo_id'])
                          ->where('caso.eliminado', '=', 0)
                          ->where('caso.activo', '=', 1)
                          ->get();
            }

            $lista = $bdObjeto->toArray();
            $tmp = Array();
            //preformatea lo que se va a imprimir
            for ($i = 0; $i < count($lista); $i++) {
                  $tmp[$i]['id'] = $lista[$i]['id'];
                  $tmp[$i]['tipo'][] = $lista[$i]['tipo'];
                  $tmp[$i]['asunto'][] = $lista[$i]['asunto'];
                  $tmp[$i]['estado'][] = $lista[$i]['estado'];
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
                    'data' => 'tipo',
                    'mData' => 'tipo'
                ),
                '2' => Array
                    (
                    'data' => 'asunto',
                    'mData' => 'asunto'
                ),
                '3' => Array
                    (
                    'data' => 'estado',
                    'mData' => 'estado'
                ),
                '4' => Array
                    (
                    'data' => 'eliminado',
                    'mData' => 'eliminado'
                )
            );

            $k = 0;
            $array['count_css'] = count($tmp);
            $array['css'] = $tmp;

            return $array;
      }

      public function guardarCasoPanelDerecho() {
          $request = new S3Request();
          $post = $request->obtenerVariables();
          $bdObjeto = $this;
          $this->cargarCampos();
         foreach ($post as $variablePost => $valorPost) {
             if (in_array($variablePost, $this->camposTabla)) {
            $bdObjeto->$variablePost = (empty($valorPost)) ? NULL : $valorPost;
             }
          }

          $bdObjeto->save();   
      }

}
