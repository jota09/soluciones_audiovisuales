<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Acuerdo extends S3TablaBD {

  protected $table = 'acuerdo';

  public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

    $this->cargarCampos();
    $bdObjeto = static::query()
            ->leftjoin('cuenta AS cta', 'cta.id', '=', 'acuerdo.cuenta_id')
            ->leftjoin('opcion_lista_maestra AS olm_n', 'olm_n.id', '=', 'acuerdo.tipo_acuerdo_id')
            //->where('cliente.eliminado', '=', '0')
            ->selectRaw("acuerdo.id, TRIM(CONCAT(IFNULL(cta.nombres,cta.nombre_comercial),' ',IFNULL(cta.apellidos,''))) AS cuenta, olm_n.nombre  AS 'tipo acuerdo', acuerdo.tipo_servicio_str AS 'tipo servicio', acuerdo.activo ");

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

}
