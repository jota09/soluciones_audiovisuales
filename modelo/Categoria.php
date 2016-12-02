<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Categoria extends S3TablaBD {

  protected $table = 'categoria';

  public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

    $bdObjeto = static::query()
            ->selectRaw("categoria.id, c.categoria_padre as 'categoria padre', categoria.referencia, olm.nombre as estado, categoria.activo ")
            ->leftjoin("view_categoria as c", "c.id", "=", "categoria.categoria_padre_id")
            ->join("opcion_lista_maestra as olm", "olm.id", "=", "categoria.estado_id");
    
    foreach ($where AS $w) {

      if (in_array($w['columna'], $this->camposTabla)) {
        $bdObjeto->where($this->table . '.' . $w['columna'], $w['condicional'], $w['valor']);
      }
    }
    
    if ($ajaxTabla) {
      $this->obtenerListaRegistrosAjaxTablaAux($bdObjeto);
    }

    if ($only) {
      $bdObjeto->take(1)->skip(0);
    }
    $bdObjeto->orderBy($this->table . '.id', 'ASC');

    $arrayCli = $bdObjeto->get()->toArray();

    if ($ajaxTabla) {
      $this->postObtenerListaRegistrosAjaxTabla($arrayCli);
    }

    return $arrayCli;
  }
  
  public function ObtenerSubCategorias($categoriaId){
    if(!empty($categoriaId)){
       $bdObjeto = static::query()
                      ->selectRaw("v.id")
                      ->leftjoin('view_categoria AS v', 'categoria.id', '=', 'v.id')
                      ->whereRaw(" v.id like '%" . $categoriaId . "%' ")
                      ->whereRaw("v.id IS NOT NULL")
                      ->get()->toArray();
       $Subcategorias = array();
       $indice=0;
       $Subcategorias[0]=0;
      foreach ($bdObjeto as $key) {
          foreach ($key as $key2 => $value) {
              $cadena = explode("-", $value);
              
              foreach ($cadena as $key3 => $value){                 
                  if($categoriaId<=$value)
                  {
                      
                    if(array_search($value, $Subcategorias, TRUE)=== FALSE ){
                    $Subcategorias[$indice++] = $value;
                    }
                  }
              }
         
          }
      }
    return $Subcategorias;
    }else{
       return 0;
    }
    
      
  }
  protected function obtenerListaRegistrosAjaxTablaAux(&$bdObjeto) {
      $request = new S3Request();
      $post = $request->obtenerVariables();
          $this->cargarCampos();

//      __P($post);
      if (isset($post['search']['value']) && $post['search']['value'] != '') {
         $where = '(';
         foreach ($this->camposTabla AS $c) {
            if (preg_match('/./', $c)) {
               $tmpC = explode('.', $c);
               $c = implode('`.`', $tmpC);
            }

            $where .= '`' . $this->table . '`.`' . $c . '` LIKE "%' . $post['search']['value'] . '%" OR ';
         }

         $whereAux = substr($where, 0, -4) . ')';
         $bdObjeto->whereRaw($whereAux);
//      __P($where);

       }
       
        $tmpObj = clone $bdObjeto;
        $this->cantFil = $tmpObj->count();

      $this->modObtenerListaRegistrosAjaxTabla($bdObjeto);
      $bdObjeto->take($post['length'])->skip($post['start']);
//      __P($bdObjeto);
  }
  
   public function guardar(&$bdObjeto) {
        global $aplicacion;
        $this->cargarCampos();
 
        $request = new S3Request();
        $registroId = $request->obtenerVariablePGR('registro_id');
        $variablesPost = $request->obtenerVariables();
 
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
            $bdObjeto->estado_id = 4; //Define estado por defecto ACTIVO
            $this->preguardar($bdObjeto);
            $bdObjeto->save();
            $this->postguardar($bdObjeto);
        }
 
        return $bdObjeto;
    }

}
