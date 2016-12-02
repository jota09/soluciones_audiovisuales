<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Convenio extends S3TablaBD {

  protected $table = 'convenio';

  public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

    $this->cargarCampos();
    $bdObjeto = static::query()
            ->leftjoin('cuenta AS cta', 'cta.id', '=', 'convenio.cuenta_id')
            ->selectRaw("convenio.id, TRIM(CONCAT(IFNULL(cta.nombres,cta.nombre_comercial),' ',IFNULL(cta.apellidos,''))) AS cuenta, convenio.tipo_servicio_str AS 'convenios', convenio.activo ");

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
                 ->selectRaw('convenio.*')
                 ->where('convenio.cuenta_id', '=', $parametros['modulo_id'])
                 ->where('convenio.eliminado', '=', 0)
                 ->where('convenio.activo', '=', 1)
                 ->get();
      }
      
      $lista = $bdObjeto->toArray();
      $tmp = Array();
      //preformatea lo que se va a imprimir
      for ($i = 0; $i < count($lista); $i++) {
         $tmp[$i]['id'] = $lista[$i]['id'];
         $tmp[$i]['tipo_servicio_str'][] = $lista[$i]['tipo_servicio_str'];
         $tmp[$i]['fecha_vigencia_desde'][] = $lista[$i]['fecha_vigencia_desde'];
         $tmp[$i]['fecha_vigencia_hasta'][] = $lista[$i]['fecha_vigencia_hasta'];
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
              'data' => 'eliminado',
              'mData' => 'eliminado'
          )
      );
     
      $array['count_cnv'] = count($tmp);
      $array['cnv'] = $tmp;

      return $array;
   }

}
