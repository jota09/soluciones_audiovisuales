<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Producto extends S3TablaBD {

  protected $table = 'producto';

  public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

    $bdObjeto = static::query()
            ->selectRaw("producto.id, c.categoria_padre as 'categoria', producto.referencia, producto.codigo, olm.nombre as estado, producto.activo ")
            ->leftjoin("view_categoria as c", "c.id", "=", "producto.categoria_id")
            ->join("opcion_lista_maestra as olm", "olm.id", "=", "producto.estado_id");

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
    require_once 'modelo/Actividades.php';
    $objActividades = new Actividades();
    $reg = parent::obtenerRegistro($registro);

    $reg['actividades'] = $objActividades->obtenerActividadesXrelacionId($registro);
    return $reg;
  }

  public function obtenerProductosXNombre() {

    $request = new S3Request();
    $variablesPost = $request->obtenerVariables();
//    __P($variablesPost);
    if (isset($variablesPost['cotizacion']) && $variablesPost['cotizacion']) {
      // buscar precio
      require_once 'modelo/Precio.php';
      $precio = new Precio();

//    __P($variablesPost);
      $registros1 = $precio->obtenerProductosFechaCuenta($variablesPost['fecha_cotizacion'], $variablesPost['cuenta']);

      if (sizeof($registros1) == 0) {
        $registros1 = $precio->obtenerProductosFechaClasificacion($variablesPost['fecha_cotizacion'], $variablesPost['cuenta']);
      }
    } else {
      
      $bdObjeto = static::query()
                      ->selectRaw("producto.*, vc.categoria_padre as categoria")
                      ->join("categoria", "categoria.id", "=", "producto.categoria_id")
                      ->join("view_categoria as vc", "categoria.id", "=", "vc.id_general")
                      ->where('producto.activo', '=', 1)
                      ->where('producto.eliminado', '=', 0)
                      ->whereRaw("producto.referencia LIKE '%" . $variablesPost['nombre'] . "%' ")
                      ->take(10)->skip(0)->get();

      $registros1 = $bdObjeto->toArray();
    }
     if (!empty($registros1)) {
     return $registros1;}
     else {
       $bdObjeto = static::query()
                      ->selectRaw("COUNT(*) as referencia")
                      ->leftjoin("lista_precio_producto", "lista_precio_producto.producto_id", "=", "producto.id")
                      ->leftjoin("lista_precio", "lista_precio.id", "=", "lista_precio_producto.lista_precio_id")
                      ->where('lista_precio.cuenta_id', '=', $variablesPost['cuenta'])
                      ->take(10)->skip(0)->get();

      $registros2 = $bdObjeto->toArray();
      
      if($registros2[0]['referencia']>0)
         {
         return $registros1;
      }
      else 
         {
         $registros2[0]['referencia'] = 'No tiene lista de precio esta cuenta';
         return $registros2; 

      }
   
    }
        
  }
  
  public function productosXCategoria($categoriaId){
//    __P($categoriaId);
    foreach ($categoriaId as $key => $value) {
        settype($value, "string");
        $categorias = $categorias."".$value.",";
    }
    $categorias = substr ($categorias, 0, -1);
      if(!empty($categoriaId)){
       $bdObjeto = static::query()
                      ->selectRaw("producto.*")
                      ->whereRaw("producto.categoria_id  IN (".$categorias.")")
                      ->where('producto.activo', '=', 1)
                      ->where('producto.eliminado', '=', 0)
                      ->count();
//    __P($bdObjeto);
      return $bdObjeto;
    }else{
       return 0;
    }
    
      
  }
  
  public function guardar(&$bdObjeto) {

      global $aplicacion;
      $this->cargarCampos();

      $request = new S3Request();
      $registroId = $request->obtenerVariablePGR('registro_id');
      $variablesPost = $request->obtenerVariables();
//      __P($variablesPost['categoria_padre_id']);
      if (!empty($registroId)) {
         $bdObjeto = static::query()
                 ->find($registroId);
      } else {
         $bdObjeto = $this;
      }

      foreach ($variablesPost as $variablePost => $valorPost) {
         if (in_array($variablePost, $this->camposTabla)) {
            $bdObjeto->$variablePost = (empty($valorPost)) ? NULL : $valorPost;
         }
      }

//__P('hola');

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
         $bdObjeto->categoria_id = $variablesPost['categoria_padre_id'];

         $this->preguardar($bdObjeto);
//         __P($bdObjeto);
         $bdObjeto->save();
         $this->postguardar($bdObjeto);
      }
      return $bdObjeto;
   }
   
   public function obtener_relacionados($parametros) {
         if ($parametros['modulo_name'] == 'cotizaciones') {

                  $bdObjeto = static::query()
                          ->selectRaw('producto.id, c.referencia as categoria, producto.referencia, producto.codigo, producto.descripcion, lpp.precio')
                          ->join("categoria as c", "c.id", "=", "producto.categoria_id")
                          ->join("lista_precio_producto as lpp", "lpp.producto_id", "=", "producto.id")
                          ->join("lista_precio as lp", "lpp.lista_precio_id", "=", "lp.id")
                          ->whereRaw('"' . $parametros['fecha_cierre'] . '" between lp.fecha_inicio and lp.fecha_fin and lp.cuenta_id = ' . $parametros['cuenta_id'])
                          ->where('lp.eliminado', '=', 0)
                          ->where('lp.activo', '=', 1)
                          ->where('lpp.eliminado', '=', 0)
                          ->where('producto.eliminado', '=', 0)
                          ->where('producto.activo', '=', 1)
                          ->orderBy('producto.id', 'ASC')
                          ->get();
            }

            $lista = $bdObjeto->toArray();
            $tmp = Array();
            //preformatea lo que se va a imprimir
            for ($i = 0; $i < count($lista); $i++) {
                  $tmp[$i]['id'] = $lista[$i]['id'];
                  $tmp[$i]['categoria'][] = $lista[$i]['categoria'];
                  $tmp[$i]['referencia'][] = $lista[$i]['referencia'];
                  $tmp[$i]['codigo'][] = $lista[$i]['codigo'];
                  $tmp[$i]['descripcion'][] = $lista[$i]['descripcion'];
                  $tmp[$i]['precio'][] = $lista[$i]['precio'];
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
                    'data' => 'categoria',
                    'mData' => 'categoria'
                ),
                '2' => Array
                    (
                    'data' => 'referencia',
                    'mData' => 'referencia'
                ),
                '3' => Array
                    (
                    'data' => 'codigo',
                    'mData' => 'codigo'
                ),
                '4' => Array
                    (
                    'data' => 'descripcion',
                    'mData' => 'descripcion'
                ),
                '5' => Array
                    (
                    'data' => 'precio',
                    'mData' => 'precio'
                )
            );
            
            $array['pro'] = $tmp;

            return $array;
      }

}