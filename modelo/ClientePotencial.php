<?php

if (!defined('s3_entrada') || !s3_entrada) {
   die('No es un punto de entrada valido');
}

class ClientePotencial extends S3TablaBD {

   protected $table = 'cliente_potencial';

   protected function preguardar(&$bdObjeto) {
      $post = new S3Request();
      $post = $post->obtenerVariables();
      $fecha = explode('-', $post['fecha_nacimiento']);
      $fecha[0] = 2016;
      $post['fecha_nacimiento'] = implode('-', $fecha);
      switch ($post['naturaleza_id']) {
         case '1'://Natural
            $bdObjeto->nombre_comercial = NULL;
            $bdObjeto->razon_social = NULL;
            break;
         case '2':
            $bdObjeto->nombres = NULL;
            $bdObjeto->apellidos = NULL;
            break;
      }
   }

   protected function postguardar(&$bdObjeto) {

      require_once 'modelo/Telefono.php';
      require_once 'modelo/Direccion.php';
      require_once 'modelo/Correo.php';

      $request = new S3Request();
      $post = $request->obtenerVariables();

      foreach ($post['telefono_id'] as $k => $v) {
         $tel = new Telefono();
         $tel->guardar($bdObjeto->id, 'Cliente_potencial_telefono', $k);
      }

      foreach ($post['direccion_id'] as $k => $v) {
         $dir = new Direccion();
         $dir->guardar($bdObjeto->id, 'Cliente_potencial_direccion', $k);
      }

      foreach ($post['correo_id'] as $k => $v) {
         $cor = new Correo();
         $cor->guardar($bdObjeto->id, 'Cliente_potencial_correo', $k);
      }
//    __P($bdObjeto->id);

      $peticion = array(
          'modulo' => 'clientes_potenciales',
          'accion' => 'editar',
          'parametros' => array('registro' => $bdObjeto->id)
      );

      $request->redireccionar($peticion);
      //    __P($aplicacion);
   }
   protected function postguardarConvertir(&$bdObjeto) {

      require_once 'modelo/Telefono.php';
      require_once 'modelo/Direccion.php';
      require_once 'modelo/Correo.php';

      $request = new S3Request();
      $post = $request->obtenerVariables();

      foreach ($post['telefono_id'] as $k => $v) {
         $tel = new Telefono();
         $tel->guardar($bdObjeto->id, 'Cliente_potencial_telefono', $k);
      }

      foreach ($post['direccion_id'] as $k => $v) {
         $dir = new Direccion();
         $dir->guardar($bdObjeto->id, 'Cliente_potencial_direccion', $k);
      }

      foreach ($post['correo_id'] as $k => $v) {
         $cor = new Correo();
         $cor->guardar($bdObjeto->id, 'Cliente_potencial_correo', $k);
      }
//    __P($bdObjeto->id);

      $peticion = array(
          'modulo' => 'clientes_potenciales',
          'accion' => 'editar',
          'parametros' => array('registro' => $bdObjeto->id,
              'convertido' => 1)
      );

      $request->redireccionar($peticion);
      //    __P($aplicacion);
   }

   public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

      $this->cargarCampos();
      $bdObjeto = static::query()->selectRaw($this->table.'.*')
              ->leftjoin('opcion_lista_maestra AS olm', 'olm.id', '=', 'cliente_potencial.estado_id')
              ->leftjoin('opcion_lista_maestra AS olmC', 'olmC.id', '=', 'cliente_potencial.clasificacion_id')
              //->leftjoin('opcion_lista_maestra AS olm_n', 'olm_n.id', '=', 'cliente_potencial.naturaleza_id')
              //->where('cliente.eliminado', '=', '0')
              ->join('usuario as u1', 'u1.id', '=', 'cliente_potencial.asesor_id')
              ->selectRaw("cliente_potencial.id ,TRIM(CONCAT(cliente_potencial.nombres,' ',cliente_potencial.apellidos)) AS nombres, 'nombre empresa', IF(convertido = 0, 'No', 'Si') as convertido, olm.nombre as estado, olmC.nombre as clasificacion, CONCAT (u1.nombres,' ', u1.apellidos)  as 'asesor asignado', cliente_potencial.activo ");

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

   public function obtenerRegistro($registro) {
      require_once 'modelo/Telefono.php';
      require_once 'modelo/Direccion.php';
      require_once 'modelo/Correo.php';
      require_once 'modelo/View_ubicacion.php';

      $bdObjeto = static::query()
                      ->where('eliminado', '=', 0)
                      ->where('id', '=', $registro)->get()->first();

      $reg = array();
      if (!empty($bdObjeto)) {
         $reg = $bdObjeto->toArray();
      }

      $objViewUbicacion = new View_ubicacion();

      if (!empty($registro)) {
         $objTel = new Telefono();
         $objDir = new Direccion();
         $objCorreo = new Correo();

         $reg['telefonos'] = $objTel->obtenerTelefonoXModulo($registro, "cliente_potencial");
         $reg['direcciones'] = $objDir->obtenerDireccionXModulo($registro, "cliente_potencial");
         $reg['correos'] = $objCorreo->obtenerCorreoXModulo($registro, "cliente_potencial");
      }

      $reg_ubicacion = $objViewUbicacion->obtenerRegistro($reg['view_ubicacion_id']);
      $reg['view_ubicacion_nombre'] = $reg_ubicacion['ubicacion'];



      return $reg;
   }

   public function obtenerClientesPotenciales() {

      return static::query()
                      ->selectRaw("cliente_potencial.id, concat(cliente_potencial.nombres, ' ', cliente_potencial.apellidos) as nombre")
                      ->where('cliente_potencial.eliminado', '=', '0')
                      ->get()->toArray();
   }

   public function comprobarDuplicado($nombres, $apellidos, $naturaleza) {

      return static::query()
                      ->where('eliminado', '=', '0')
                      ->where('activo', '=', '1')
                      ->whereRaw(" nombres LIKE '%$nombres%' AND  apellidos LIKE '%$apellidos%' AND naturaleza_id=$naturaleza ")
                      ->get()->toArray();
   }

   public function comprobarDuplicadoXtermino($termino) {

      return static::query()
                      ->where('eliminado', '=', '0')
                      ->where('activo', '=', '1')
                      ->whereRaw(" nombres LIKE '%$termino%' OR  apellidos LIKE '%$termino%'")
                      ->limit(5)
                      ->get()->toArray();
   }

   public function convertir($registroId) {
      $request = new S3Request();
      $post = $request->obtenerVariables();
//    __P($post);
      $bdObjeto = static::query()
              ->find($registroId);
      $this->cargarCampos();
      foreach ($post as $variablePost => $valorPost) {
         if (in_array($variablePost, $this->camposTabla)) {
            $bdObjeto->$variablePost = (empty($valorPost)) ? NULL : $valorPost;
         }
      }
//    __P($bdObjeto);
      $bdObjeto->convertido = 1;
      $bdObjeto->estado_id = 98;

      $bdObjeto->save();
      $this->postguardarConvertir($bdObjeto);
   }

   public function obtenerDescendientes($clientePotencialID) {
      $object = static::query()
                      ->selectRaw("cta.nombre_comercial as cuenta, cta.id as cuenta_id, cnt.id as contacto_id, CONCAT(cnt.nombres,' ', cnt.apellidos) as contacto, opp.referencia as oportunidad, opp.id as oportunidad_id")
                      ->join("cuenta as cta", "cta.cliente_potencial_id", "=", "cliente_potencial.id")
                      ->join("contacto as cnt", "cnt.cliente_potencial_id", "=", "cliente_potencial.id")
                      ->leftjoin("oportunidad as opp", "opp.cliente_potencial_id", "=", "cliente_potencial.id")
                      ->where('cliente_potencial.eliminado', '=', '0')
                      ->where('cliente_potencial.activo', '=', '1')
                      ->whereRaw('cliente_potencial.convertido = 1 AND cliente_potencial.id = ' . $clientePotencialID)
                      ->get()->toArray();

      return $object;
   }

   public function obtenerRegistroUltimaAct($registro) {

      $bdObjeto = static::query()
                      ->selectRaw("`actividad`.`id` AS bandera,IFNULL(`actividad`.`id`,`cliente_potencial`.`fecha_creacion`) AS Fecha_inicio")
                      ->leftjoin('cliente_potencial_actividad', 'cliente_potencial.id', '=', 'cliente_potencial_actividad.cliente_potencial_id')
                      ->leftjoin('actividad', 'cliente_potencial_actividad.actividad_id', '=', 'actividad.id')
                      ->leftjoin('usuario', 'cliente_potencial.asesor_id', '=', 'usuario.id')
                      ->where('cliente_potencial.id', '=', $registro['id'])
                      ->groupBy('cliente_potencial.id')->orderBy('actividad.fecha_creacion', 'DESC')
                      ->get()->toArray();
//    __P($bdObjeto[0]);
      return $bdObjeto[0];
   }

   /**
    * @todo Metodo para aplicar los filtros básicos del JQuery DataTables
    * @param Object $bdObjeto
    */
   protected function obtenerListaRegistrosAjaxTabla(&$bdObjeto) {
      $request = new S3Request();
      $post = $request->obtenerVariables();

      $filtrar = false;

      if (isset($post['_filtros']) && !empty($post['_filtros'])) {
         $where = '(';

         foreach ($post['_filtros'] AS $campo => $valor) {
            if ($valor != '' && $campo!='f_15') {
               $filtrar = true;
               if (preg_match('/./', $campo)) {
                  $tmpC = explode('.', $campo);
                  $campo = implode('`.`', $tmpC);
               }
               if (strpos($campo, '_rel_') === false) {
                  if (is_array($valor)) {
                     $where .= $this->table . '.`' . $campo . '` IN(' . implode(',', $valor) . ') AND ';
                  } else {
                     $where .= $this->table . '.`' . $campo . '` LIKE "%' . $valor . '%" AND ';
                  }
               } else {
                  $new_campo = str_replace('_rel_', '', $campo);
                  $where .= $this->table . '.`' . $new_campo . '` IN(' . implode(',', $valor) . ') AND ';
               }
            }
         }

         $where = substr($where, 0, -4) . ')';

         if ($filtrar) {
            $bdObjeto->whereRaw($where);
         }
      }
      if (isset($post['_filtros']['f_15']) && !empty($post['_filtros']['f_15'])){
         $bdObjeto->join('cliente_potencial_correo AS cpc', 'cpc.cliente_potencial_id', '=', 'cliente_potencial.id')
            ->join('correo as c', 'c.id', '=', 'cpc.correo_id')
            ->whereRaw('c.correo LIKE "%' . $post['_filtros']['f_15'] . '%"');
      }

      if (isset($post['search']['value']) && $post['search']['value'] != '') {
         $where = '(';
         foreach ($this->camposTabla AS $c) {
            if (preg_match('/./', $c)) {
               $tmpC = explode('.', $c);
               $c = implode('`.`', $tmpC);
            }

            $where .= '`' . $this->table . '.' . $c . '` LIKE "%' . $post['search']['value'] . '%" OR ';
         }

         $where = substr($where, 0, -4) . ')';
         $bdObjeto->whereRaw($where);

         $tmpObj = clone $bdObjeto;
         $this->cantFil = $tmpObj->count();
      }

      $this->modObtenerListaRegistrosAjaxTabla($bdObjeto);
      $bdObjeto->take($post['length'])->skip($post['start']);
   }

}
