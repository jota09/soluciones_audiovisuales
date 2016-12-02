<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Precio extends S3TablaBD {

  protected $table = 'lista_precio_producto';

  public function obtenerPrecioXLista($lista_id) {

    $bdObjeto = static::query()
            ->selectRaw("FORMAT(lista_precio_producto.precio, 0) as precio, lista_precio_producto.id as precio_id, p.id as producto_id, p.referencia, p.codigo, p.descripcion, c.referencia as categoria")
            ->join("producto as p", "p.id", "=", "lista_precio_producto.producto_id")
            ->join("categoria as c", "c.id", "=", "p.categoria_id")
            ->where('lista_precio_producto.lista_precio_id', '=', $lista_id)
            ->where('lista_precio_producto.eliminado', '=', 0);

    $bdObjeto->orderBy($this->table . '.id', 'DESC');

    $arrayCli = $bdObjeto->get()->toArray();
//    __P($arrayCli);
    return $arrayCli;
  }

  public function guardar($lista_precio) {

    global $aplicacion;
    $this->cargarCampos();

    $request = new S3Request();
    $post = $request->obtenerVariables();
//    __P($post);
    foreach ($post['precio_id'] as $k => $v) {
     
      if (!empty($v)) {
        $bdObjeto = static::query()
                ->find($v);
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

        $bdObjeto->lista_precio_id = $lista_precio;
        $bdObjeto->producto_id = $post['producto_id'][$k];
        $bdObjeto->precio = str_replace(",", "", $post['precio'][$k]);
//    __P($bdObjeto);
        $bdObjeto->eliminado = $post['precio_eliminado'][$k];

        $bdObjeto->save();
      } else {

        if (in_array('creado_por', $this->camposTabla)) {

          $data['creado_por'] = $aplicacion->getUsuario()->getId();
        }
        if (in_array('fecha_creacion', $this->camposTabla)) {

          $data['fecha_creacion'] = date('Y-m-d H:i:s');
        }
        $data['lista_precio_id'] = $lista_precio;
        $data['producto_id'] = $post['producto_id'][$k];
        $data['precio'] = str_replace(",", "", $post['precio'][$k]);
        $data['eliminado'] = $post['precio_eliminado'][$k];

        static::insert($data);
      }
//      unset($bdObjeto);
    }
  }

  function obtenerProductosFechaCuenta($fecha, $cuenta) {
     $request = new S3Request();
     $variablesPost = $request->obtenerVariables();
     
    $bdObjeto = static::query()
                    ->selectRaw("lista_precio_producto.precio, p.id as producto_id, p.referencia, p.descripcion, p.codigo, c.referencia as categoria")
                    ->join("producto as p", "p.id", "=", "lista_precio_producto.producto_id")
                    ->join("categoria as c", "c.id", "=", "p.categoria_id")
                    ->join("lista_precio as lp", "lp.id", "=", "lista_precio_producto.lista_precio_id")
                    ->whereRaw('"' . $fecha . '" between lp.fecha_inicio and lp.fecha_fin and lp.cuenta_id = ' . $cuenta)                   ->whereRaw("p.referencia LIKE '%" . $variablesPost['nombre'] . "%' ")
                    ->take(10)->skip(0);

    $bdObjeto->orderBy('p.referencia', 'ASC');

    $arrayCli = $bdObjeto->get()->toArray();
//    __P($arrayCli);
    return $arrayCli;
  }

  function obtenerProductosFechaClasificacion($fecha, $cuenta) {
     $request = new S3Request();
     $variablesPost = $request->obtenerVariables();
//     __P($variablesPost);
    $bdObjeto = static::query()
                    ->selectRaw("lista_precio_producto.precio, p.id as producto_id, p.referencia, p.descripcion, p.codigo, c.referencia as categoria")
                    ->join("producto as p", "p.id", "=", "lista_precio_producto.producto_id")
                    ->join("categoria as c", "c.id", "=", "p.categoria_id")
                    ->join("lista_precio as lp", "lp.id", "=", "lista_precio_producto.lista_precio_id")
                    ->join("cuenta", "cuenta.clasificacion_id", "=", "lp.clasificacion_id")
                    ->whereRaw("p.activo = 1")
                    ->whereRaw("lista_precio_producto.eliminado = 0")
                    ->whereRaw('"' . $fecha . '" between lp.fecha_inicio and lp.fecha_fin and cuenta.id = ' . $cuenta)
                    ->take(10)->skip(0);

    $bdObjeto->orderBy('p.referencia', 'ASC');
    $arrayCli = $bdObjeto->get()->toArray();

    return $arrayCli;
  }

}