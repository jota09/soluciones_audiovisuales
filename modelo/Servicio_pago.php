<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Servicio_pago extends S3TablaBD {

  protected $table = 'servicio_pago';

  public function guardar($id, $pos) {
    global $aplicacion;
    $this->cargarCampos();
    $request = new S3Request();
    $post = $request->obtenerVariables();
//     __P($post);
    if (!empty($post['pago_id'][$pos])) {
      $bdObjeto = static::query()
              ->find($post['pago_id'][$pos]);
    } else {
      $bdObjeto = $this;
    }
    
    
    $bdObjeto->servicio_id = $id;
    $bdObjeto->fecha_pago = $post['fecha_pago'][$pos];
    $bdObjeto->valor = str_replace (',','', $post['valor'][$pos]) ;
    $bdObjeto->pagado = $post['pagado'][$pos];
    $bdObjeto->eliminado = $post['pago_eliminado'][$pos];
    
    
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
            $this->postguardar($bdObjeto);
        }
   
 
//__P($bdObjeto);
   }
   
   public function obtenerPagosServicio($ser_id) {

    $objeto = array();

    if (!empty($ser_id)) {
      $objeto = static::query()
                      ->selectRaw("servicio_pago.id,servicio_pago.fecha_pago, servicio_pago.valor , servicio_pago.pagado")
                      ->where('servicio_pago.eliminado', '=', '0')
                      ->get()->toArray();
    }
    return $objeto;
  }
}
