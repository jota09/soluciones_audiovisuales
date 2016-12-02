<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class ListaPrecio extends S3TablaBD {

  protected $table = 'lista_precio';

  public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

    $bdObjeto = static::query()
            ->selectRaw("lista_precio.id, TRIM(CONCAT(IFNULL(c.nombres,c.nombre_comercial),' ',IFNULL(c.apellidos,''))) AS cuenta,olmc.nombre as 'clasificación', lista_precio.referencia, lista_precio.fecha_inicio as 'fecha inicio', lista_precio.fecha_fin as 'fecha fin', olm.nombre as estado")
            ->leftjoin("cuenta as c", "c.id", "=", "lista_precio.cuenta_id")
            ->leftjoin("opcion_lista_maestra as olmc", "olmc.id", "=", "lista_precio.clasificacion_id")
            ->join("opcion_lista_maestra as olm", "olm.id", "=", "lista_precio.estado_id");
    
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

  public function obtenerRegistro($registro) {
    require_once 'modelo/Precio.php';
    $bdPrecio = new Precio();
    $reg = parent::obtenerRegistro($registro);

    $reg['detalle'] = $bdPrecio->obtenerPrecioXLista($registro);
    return $reg;
  }

  public function obtenerxCliente($cuenta_id) {
    return static::query()
                    ->selectRaw('oportunidad.*,inmueble.id inmueble_id,inmueble.titulo as inmueble,tipo_gestion_rel.nombre as tipo_gestion,tipo_gestion_rel.id as tipo_gestion_id,'
                            . 'gestion_inmueble.titulo gestion_inmueble_nombre,gestion_inmueble.id gestion_inmueble_id')
                    ->join('gestion_inmueble', 'gestion_inmueble.id', '=', 'oportunidad.gestion_inmueble_id')
                    ->join('inmueble', 'inmueble.id', '=', 'gestion_inmueble.inmueble_id')
                    ->join('opcion_lista_maestra AS tipo_gestion_rel', 'tipo_gestion_rel.id', '=', 'gestion_inmueble.tipo_gestion_id')
                    ->where('oportunidad.cuenta_id', '=', $cuenta_id)
                    ->where('oportunidad.eliminado', '=', 0)
                    ->where('oportunidad.activo', '=', 1)
                    ->orderBy('oportunidad.id', 'DESC')
                    ->get()->toArray();
  }

  public function obtenerxClasificacione($clasificacion_id) {
    return static::query()
                    ->selectRaw('oportunidad.*,inmueble.id inmueble_id,inmueble.titulo as inmueble,tipo_gestion_rel.nombre as tipo_gestion,tipo_gestion_rel.id as tipo_gestion_id,'
                            . 'gestion_inmueble.titulo gestion_inmueble_nombre,gestion_inmueble.id gestion_inmueble_id')
                    ->join('gestion_inmueble', 'gestion_inmueble.id', '=', 'oportunidad.gestion_inmueble_id')
                    ->join('inmueble', 'inmueble.id', '=', 'gestion_inmueble.inmueble_id')
                    ->join('opcion_lista_maestra AS tipo_gestion_rel', 'tipo_gestion_rel.id', '=', 'gestion_inmueble.tipo_gestion_id')
                    ->where('oportunidad.cuenta_id', '=', $clasificacion_id)
                    ->where('oportunidad.eliminado', '=', 0)
                    ->where('oportunidad.activo', '=', 1)
                    ->orderBy('oportunidad.id', 'DESC')
                    ->get()->toArray();
  }

  protected function postguardar(&$bdObjeto) {

    require_once 'modelo/Precio.php';
    
    $request = new S3Request();
    $precio = new Precio();

    $precio->guardar($bdObjeto->id);
    //    __P($bdObjeto->id);

      $peticion = array(
          'modulo' => 'lista_precios',
          'accion' => 'editar',
          'parametros' => array('registro' => $bdObjeto->id)
      );

      $request->redireccionar($peticion);
      //    __P($aplicacion);
  }

}
