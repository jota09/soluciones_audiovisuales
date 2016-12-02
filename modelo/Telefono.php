<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Telefono extends S3TablaBD {

  protected $table = 'telefono';

  public function guardar($id, $modulo, $pos) {
    global $aplicacion;
    $this->cargarCampos();

    if ($modulo == "Contacto_telefono") {
      
      require_once 'modelo/Contacto_telefono.php';
      $contacto_tel = new Contacto_telefono();
    } else if ($modulo == "Cliente_potencial_telefono") {
      
      require_once 'modelo/ClientePotencial_telefono.php';
      $cliente_tel = new ClientePotencial_telefono();
    } else if ($modulo == "Cuenta_telefono") {
      
      require_once 'modelo/Cuenta_telefono.php';
      $cuenta_tel = new Cuenta_telefono();
    }

     $request = new S3Request();
    $post = $request->obtenerVariables();
//    __P($post);
    
    if (!empty($post['telefono_id'][$pos])) {
      $bdObjeto = static::query()
              ->find($post['telefono_id'][$pos]);
    } else {
      $bdObjeto = $this;
    }
//    __P($bdObjeto);
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

    $bdObjeto->numero = $post['num_telefono'][$pos];
    $bdObjeto->tipo = $post['tipo_telefono'][$pos];
    $bdObjeto->eliminado = $post['telefono_eliminado'][$pos];

    $bdObjeto->save();
    if (empty($post['telefono_id'][$pos])) {
      if ($modulo == "Contacto_telefono") {
        
        $contacto_tel->guardar($id, $bdObjeto->id);
      } else if ($modulo == "Cliente_potencial_telefono") {
  
        $cliente_tel->guardar($id, $bdObjeto->id);
      } else if ($modulo == "Cuenta_telefono") {
  
        $cuenta_tel->guardar($id, $bdObjeto->id);
      }
    }
  }
  public function guardarConvertir($id, $modulo, $pos) {
    global $aplicacion;
    $this->cargarCampos();

    if ($modulo == "Contacto_telefono") {
      
      require_once 'modelo/Contacto_telefono.php';
      $contacto_tel = new Contacto_telefono();
    } else if ($modulo == "Cliente_potencial_telefono") {
      
      require_once 'modelo/ClientePotencial_telefono.php';
      $cliente_tel = new ClientePotencial_telefono();
    } else if ($modulo == "Cuenta_telefono") {
      
      require_once 'modelo/Cuenta_telefono.php';
      $cuenta_tel = new Cuenta_telefono();
    }

     $request = new S3Request();
    $post = $request->obtenerVariables();
    $post['telefono_id'][$pos] = '';
    
    if (!empty($post['telefono_id'][$pos])) {
      $bdObjeto = static::query()
              ->find($post['telefono_id'][$pos]);
    } else {
      $bdObjeto = $this;
    }
//    __P($bdObjeto);
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

    $bdObjeto->numero = $post['num_telefono'][$pos];
    $bdObjeto->tipo = $post['tipo_telefono'][$pos];
    $bdObjeto->eliminado = $post['telefono_eliminado'][$pos];

    $bdObjeto->save();
    if (empty($post['telefono_id'][$pos])) {
      if ($modulo == "Contacto_telefono") {
        
        $contacto_tel->guardar($id, $bdObjeto->id);
      } else if ($modulo == "Cliente_potencial_telefono") {
  
        $cliente_tel->guardar($id, $bdObjeto->id);
      } else if ($modulo == "Cuenta_telefono") {
  
        $cuenta_tel->guardar($id, $bdObjeto->id);
      }
    }
  }

  public function obtenerTelefonoXModulo($moduloId, $modulo) {


    $bdObjeto = static::query()
            ->selectRaw("telefono.id AS telefono_id, telefono.numero, tipo")
            ->join($modulo . "_telefono", $modulo . "_telefono.telefono_id", "=", "telefono.id")
            ->whereRaw("telefono.eliminado=0 AND " . $modulo . "_telefono.eliminado =0 AND " . $modulo . "_telefono." . $modulo . "_id = " . $moduloId)
            ->get();

    return $bdObjeto->toArray();
  }

}
