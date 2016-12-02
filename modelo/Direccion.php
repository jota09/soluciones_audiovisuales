<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Direccion extends S3TablaBD {

  protected $table = 'direccion';

  public function guardar($id, $modulo, $pos) {
    global $aplicacion;
    $this->cargarCampos();

    if ($modulo == "Contacto_direccion") {
      require_once 'modelo/Contacto_direccion.php';
      $contacto_tel = new Contacto_direccion();
      
    } else if ($modulo == "Cliente_potencial_direccion") {
      require_once 'modelo/ClientePotencial_direccion.php';
      $cliente_tel = new ClientePotencial_direccion();
      
    } else if ($modulo == "Cuenta_direccion") {
      require_once 'modelo/Cuenta_direccion.php';
      $cuenta_tel = new Cuenta_direccion();
    }

    $request = new S3Request();
    $post = $request->obtenerVariables();
    
    if (!empty($post['direccion_id'][$pos])) {
      $bdObjeto = static::query()
              ->find($post['direccion_id'][$pos]);
    } else {
      $bdObjeto = $this;
    }

    if (!empty($bdObjeto) && $bdObjeto->id > 0) {
      if (in_array('actualizado_por', $this->camposTabla)) {
        $bdObjeto->actualizado_por = $aplicacion->getUsuario()->getId();
      }
      if (in_array('fecha_modificacion', $this->camposTabla)) {
        $bdObjeto->fecha_modificacion = date('Y-m-d H:i:s');
      }
    } else {

      if (in_array('creado_por', $this->camposTabla)) {
        $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
      }
      if (in_array('fecha_creacion', $this->camposTabla)) {

        $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
      }
    }

    $bdObjeto->direccion = $post['direccion'][$pos];
    $bdObjeto->eliminado = $post['direccion_eliminado'][$pos];

    $bdObjeto->save();
    
    if (empty($post['direccion_id'][$pos])) {
      if ($modulo == "Contacto_direccion") {
        $contacto_tel->guardar($id, $bdObjeto->id);
      } else if ($modulo == "Cliente_potencial_direccion") {
        $cliente_tel->guardar($id, $bdObjeto->id);
      } else if ($modulo == "Cuenta_direccion") {
        require_once 'modelo/Cuenta_direccion.php';
        $cuenta_tel->guardar($id, $bdObjeto->id);
      }
    }
  }
  public function guardarConvertir($id, $modulo, $pos) {
    global $aplicacion;
    $this->cargarCampos();

    if ($modulo == "Contacto_direccion") {
      require_once 'modelo/Contacto_direccion.php';
      $contacto_tel = new Contacto_direccion();
      
    } else if ($modulo == "Cliente_potencial_direccion") {
      require_once 'modelo/ClientePotencial_direccion.php';
      $cliente_tel = new ClientePotencial_direccion();
      
    } else if ($modulo == "Cuenta_direccion") {
      require_once 'modelo/Cuenta_direccion.php';
      $cuenta_tel = new Cuenta_direccion();
    }

    $request = new S3Request();
    $post = $request->obtenerVariables();
    $post['direccion_id'][$pos] = '';
  
    if (!empty($post['direccion_id'][$pos])) {
      $bdObjeto = static::query()
              ->find($post['direccion_id'][$pos]);
    } else {
      $bdObjeto = $this;
    }

    if (!empty($bdObjeto) && $bdObjeto->id > 0) {
      if (in_array('actualizado_por', $this->camposTabla)) {
        $bdObjeto->actualizado_por = $aplicacion->getUsuario()->getId();
      }
      if (in_array('fecha_modificacion', $this->camposTabla)) {
        $bdObjeto->fecha_modificacion = date('Y-m-d H:i:s');
      }
    } else {

      if (in_array('creado_por', $this->camposTabla)) {
        $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
      }
      if (in_array('fecha_creacion', $this->camposTabla)) {

        $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
      }
    }

    $bdObjeto->direccion = $post['direccion'][$pos];
    $bdObjeto->eliminado = $post['direccion_eliminado'][$pos];

    $bdObjeto->save();
    
    if (empty($post['direccion_id'][$pos])) {
      if ($modulo == "Contacto_direccion") {
        $contacto_tel->guardar($id, $bdObjeto->id);
      } else if ($modulo == "Cliente_potencial_direccion") {
        $cliente_tel->guardar($id, $bdObjeto->id);
      } else if ($modulo == "Cuenta_direccion") {
        require_once 'modelo/Cuenta_direccion.php';
        $cuenta_tel->guardar($id, $bdObjeto->id);
      }
    }
  }

  public function obtenerDireccionXModulo($moduloId, $modulo) {
    $bdObjeto = static::query()
            ->selectRaw("direccion.id AS direccion_id, direccion, barrio, tipo")
            ->join($modulo . "_direccion", $modulo . "_direccion.direccion_id", "=", "direccion.id")
            ->whereRaw("direccion.eliminado=0 AND " . $modulo . "_direccion.eliminado =0 AND " . $modulo . "_direccion." . $modulo . "_id = " . $moduloId)
            ->get();

    return $bdObjeto->toArray();
  }

}
