<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Cotizacion_detalle extends S3TablaBD {

  protected $table = 'detalle_cotizacion';

  public function guardar($cotizacion_id, $pos) {

    global $aplicacion;
    $this->cargarCampos();

    $request = new S3Request();
    $post = $request->obtenerVariables();
    if (!empty($post['detalle_cotizacion_id'][$pos])) {
      $bdObjetoD = static::query()
              ->find($post['detalle_cotizacion_id'][$pos]);
    } else {
      $bdObjetoD = $this;
    }

    $bdObjetoD->cotizacion_id = $cotizacion_id;
    $bdObjetoD->producto_id = $post['detalle_producto_id'][$pos];
    $bdObjetoD->valor_unitario = str_replace(",", "", $post['detalle_valor_unitario'][$pos]);
    $bdObjetoD->cantidad = $post['detalle_cantidad'][$pos];
    $bdObjetoD->eliminado = $post['detalle_cotizacion_eliminado'][$pos];

    if (!empty($bdObjetoD) && $bdObjetoD->id > 0) {

      if (in_array('actualizado_por', $this->camposTabla)) {
        $bdObjetoD->actualizado_por = $aplicacion->getUsuario()->getId();
      }
      if (in_array('fecha_modificacion', $this->camposTabla)) {
        $bdObjetoD->fecha_modificacion = date('Y-m-d H:i:s');
      }
    } else {

      if (in_array('creado_por', $this->camposTabla)) {
        $bdObjetoD->creado_por = $aplicacion->getUsuario()->getId();
      }
      if (in_array('fecha_creacion', $this->camposTabla)) {
        $bdObjetoD->fecha_creacion = date('Y-m-d H:i:s');
      }
    }

    $bdObjetoD->save();
    return $bdObjetoD->id;

  }

  public function obtenerDetalleCotizacion($cot_id) {

    $objeto = array();

    if (!empty($cot_id)) {
      $objeto = static::query()
                      ->selectRaw("p.referencia, p.descripcion, ctg.referencia as categoria, detalle_cotizacion.id, FORMAT(detalle_cotizacion.valor_unitario, 0) as valor_unitario, FORMAT(detalle_cotizacion.valor_unitario * detalle_cotizacion.cantidad, 0) as detalle_total, detalle_cotizacion.producto_id, detalle_cotizacion.cantidad")
                      ->join("producto as p", "p.id", "=", "detalle_cotizacion.producto_id")
                      ->join("categoria as ctg", "ctg.id", "=", "p.categoria_id")
                      ->where('detalle_cotizacion.eliminado', '=', '0')
                      ->whereRaw(" detalle_cotizacion.cotizacion_id = " . $cot_id)
                      ->get()->toArray();
    }


    return $objeto;
  }

}
