<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Caso_actividad extends S3TablaBD {

    protected $table = 'caso_actividad';
    
    public function guardar($moduloId, $actividadId) {
        $data = array(
            "caso_id" => $moduloId,
            "actividad_id" => $actividadId
        );
        static::insert($data);
    }

   public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {
    $post = new S3Request();
    $post = $post->obtenerVariables();
    $this->cargarCampos();
    $bdObjeto = static::query()
            ->join('caso', 'caso_actividad.caso_id', '=', 'caso.id')
            ->join('actividad AS a', 'a.id', '=', 'caso_actividad.actividad_id')
            ->selectRaw("SUM(a.duracion) as duracion")
            ->where('caso.id', '=', $post['registro'])
            ->where('caso.eliminado', '=', 0)
            ->where('caso.activo', '=', 1)
            ->where('a.eliminado', '=', 0)
            ->where('a.activo', '=', 1);

    foreach ($where AS $w) {

      if (in_array($w['columna'], $this->camposTabla)) {
        $bdObjeto->where($this->table . '.' . $w['columna'], $w['condicional'], $w['valor']);
      }
    }

    if ($ajaxTabla) {
      $this->obtenerListaRegistrosAjaxTabla($bdObjeto,$filtro);
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

}
