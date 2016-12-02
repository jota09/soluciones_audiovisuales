<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Contacto extends S3TablaBD {

  protected $table = 'contacto';

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

      $reg['telefonos'] = $objTel->obtenerTelefonoXModulo($registro, "contacto");
      $reg['direcciones'] = $objDir->obtenerDireccionXModulo($registro, "contacto");
      $reg['correos'] = $objCorreo->obtenerCorreoXModulo($registro, "contacto");
    }
    $reg_ubicacion = $objViewUbicacion->obtenerRegistro($reg['view_ubicacion_id']);
    $reg['view_ubicacion_nombre'] = $reg_ubicacion['ubicacion'];


//__P($reg);
    return $reg;
  }

  protected function postguardar(&$bdObjeto) {

    require_once 'modelo/Telefono.php';
    require_once 'modelo/Direccion.php';
    require_once 'modelo/Correo.php';

    $request = new S3Request();
    $post = $request->obtenerVariables();
//    __P($post);
    foreach ($post['telefono_id'] as $k => $v) {
      $tel = new Telefono();
      $tel->guardar($bdObjeto->id, 'Contacto_telefono', $k);
    }

    foreach ($post['direccion_id'] as $k => $v) {
      $dir = new Direccion();
      $dir->guardar($bdObjeto->id, 'Contacto_direccion', $k);
    }

    foreach ($post['correo_id'] as $k => $v) {
      $cor = new Correo();
      $cor->guardar($bdObjeto->id, 'Contacto_correo', $k);
    }
  }
  protected function postguardarModal(&$bdObjeto) {

    require_once 'modelo/Telefono.php';
    require_once 'modelo/Direccion.php';
    require_once 'modelo/Correo.php';
    require_once 'modelo/Oportunidad_contacto.php';

    $request = new S3Request();
    $post = $request->obtenerVariables();
    foreach ($post['telefono_id'] as $k => $v) {
      $tel = new Telefono();
      $tel->guardar($bdObjeto->id, 'Contacto_telefono', $k);
    }

    foreach ($post['direccion_id'] as $k => $v) {
      $dir = new Direccion();
      $dir->guardar($bdObjeto->id, 'Contacto_direccion', $k);
    }

    foreach ($post['correo_id'] as $k => $v) {
      $cor = new Correo();
      $cor->guardar($bdObjeto->id, 'Contacto_correo', $k);
    }
    $variablesRelacion['contacto_id']= $bdObjeto->id;  
    $variablesRelacion['oportunidad_id']= $post['oportunidad_id'];  
    $variablesRelacion['rol_id']= $post['rol_id'];  
    $opp_contacto = new OportunidadContacto();
    $opp_contacto->guardar_opp_contact($variablesRelacion);
  }
  
  protected function postguardarConvertir(&$bdObjeto) {

    require_once 'modelo/Telefono.php';
    require_once 'modelo/Direccion.php';
    require_once 'modelo/Correo.php';

    $request = new S3Request();
    $post = $request->obtenerVariables();
    foreach ($post['telefono_id'] as $k => $v) {
      $tel = new Telefono();
      $tel->guardarConvertir($bdObjeto->id, 'Contacto_telefono', $k);
    }

    foreach ($post['direccion_id'] as $k => $v) {
       $dir = new Direccion();
      $dir->guardarConvertir($bdObjeto->id, 'Contacto_direccion', $k);
    }

    foreach ($post['correo_id'] as $k => $v) {
       $cor = new Correo();
      $cor->guardarConvertir($bdObjeto->id, 'Contacto_correo', $k);
    }
  }

  public function obtenerListaRegistrosRol($registro) {
    $this->cargarCampos();
    $bdObjeto = static::query()
            ->leftjoin('oportunidad_contacto AS oc', 'oc.contacto_id', '=', 'contacto.id')
            ->selectRaw("contacto.id ,CONCAT(contacto.nombres,' ', contacto.apellidos) AS nombres, contacto.cargo")
            ->whereRaw(" oc.id IS NULL  AND contacto.`cuenta_id` = ".$registro['cuenta_id']." ")
            ->where("contacto.eliminado", "=", 0);

    

    $arrayCli = $bdObjeto->get()->toArray();
//      __P($bdObjeto->toSql());

    return $arrayCli;
  }
  public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

    $this->cargarCampos();
    $bdObjeto = static::query()
            ->leftjoin('opcion_lista_maestra AS olm', 'olm.id', '=', 'contacto.estado_id')
            ->join('cuenta AS olmT', 'olmT.id', '=', 'contacto.cuenta_id')
            ->join('usuario AS olmA', 'olmA.id', '=', 'contacto.asesor_id')
            ->selectRaw("contacto.id ,CONCAT(contacto.nombres,' ', contacto.apellidos) AS nombres, contacto.cargo , TRIM(CONCAT(IFNULL(olmT.nombres,olmT.nombre_comercial),' ',IFNULL(olmT.apellidos,''))) AS cuenta, CONCAT(olmA.nombres,'',olmA.apellidos) as asesor, olm.nombre as estado , contacto.activo ");

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

  public function convertirContacto($informacion, $cuenta) {
    global $aplicacion;
    $this->cargarCampos();

    $variablesPost = $informacion;
    $bdObjeto = $this;

    foreach ($variablesPost as $variablePost => $valorPost) {
      if (in_array($variablePost, $this->camposTabla)) {
        $bdObjeto->$variablePost = (empty($valorPost)) ? NULL : $valorPost;
      }
    }

    $bdObjeto->cuenta_id = $cuenta;
    $bdObjeto->estado_id = 4;
    $bdObjeto->cliente_potencial_id = $variablesPost['registro_id'];

    if (in_array('creado_por', $this->camposTabla)) {
      $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
    }
    if (in_array('fecha_creacion', $this->camposTabla)) {

      $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
    }

    $bdObjeto->save();
    $this->postguardarConvertir($bdObjeto);

    return $bdObjeto;
  }

//traer los documentos por modulo y id
  public function obtener_relacionados($parametros) {



    if ($parametros['modulo_name'] == 'oportunidades') {
      $bdObjeto = static::query()
              ->selectRaw("contacto.id as id, CONCAT(contacto.nombres,' ', contacto.apellidos) AS nombres, cargo, tipo_rol.nombre as nombre_rol")
              ->join("oportunidad_contacto as oc", "oc.contacto_id", "=", "contacto.id")
              ->join("opcion_lista_maestra as tipo_rol", "oc.rol_id", "=", "tipo_rol.id")
              ->whereRaw('oc.oportunidad_id = ' . $parametros['modulo_id'])
              ->where('oc.eliminado', '=', '0')
              ->where('contacto.eliminado', '=', '0')
              ->orderBy('contacto.id', 'DESC')
              ->get();
    }
    if ($parametros['modulo_name'] == 'cuentas') {
      $bdObjeto = static::query()
              ->selectRaw("contacto.id as id, CONCAT(contacto.nombres,' ', contacto.apellidos) AS nombres, cargo")
              ->whereRaw('cuenta_id = ' . $parametros['modulo_id'])
              ->where('eliminado', '=', '0')
              ->orderBy('id', 'DESC')
              ->get();
    }

    $lista = $bdObjeto->toArray();
    $tmp = Array();
    //preformatea lo que se va a imprimir
    for ($i = 0; $i < count($lista); $i++) {
      $tmp[$i]['id'] = $lista[$i]['id'];
      $tmp[$i]['nombres'][] = $lista[$i]['nombres'];
      $tmp[$i]['cargo'][] = $lista[$i]['cargo'];
      $tmp[$i]['eliminado'] = '<i class=" fa fa-minus"></i>';
      if(isset($lista[$i]['nombre_rol'])){
      $tmp[$i]['nombre_rol'][] = $lista[$i]['nombre_rol'];}
        
    }
    if(!isset($lista[0]['nombre_rol'])){
    $array['campos'] = Array
        (
        '0' => Array
            (
            'data' => 'id',
            'mData' => 'id'
        ),
        '1' => Array
            (
            'data' => 'nombres',
            'mData' => 'nombres'
        ),
        '2' => Array
            (
            'data' => 'cargo',
            'mData' => 'cargo'
        ),
        '3' => Array
            (
            'data' => 'eliminado',
            'mData' => 'eliminado'
        )
    );
   }
   else
   {
      $array['campos'] = Array
        (
        '0' => Array
            (
            'data' => 'id',
            'mData' => 'id'
        ),
        '1' => Array
            (
            'data' => 'nombres',
            'mData' => 'nombres'
        ),
        '2' => Array
            (
            'data' => 'cargo',
            'mData' => 'cargo'
        ),
        '3' => Array
              (
              'data' => 'nombre_rol',
              'mData' => 'nombre_rol'
          ),  
        '4' => Array
            (
            'data' => 'eliminado',
            'mData' => 'eliminado'
        )
    );
   }

    $array['count_cntcts'] = count($tmp);
    $array['cntcts'] = $tmp;

    return $array;
  }

  public function obtenerContactosActividad() {
    
    $objecto = static::query()
                    ->selectRaw("contacto.id as id, CONCAT(contacto.nombres,' ', contacto.apellidos) AS nombre, c.correo")
                    ->join("contacto_correo as cc", "cc.contacto_id", "=", "contacto.id")
                    ->join("correo as c", "c.id", "=", "cc.correo_id")
                    ->where("c.principal", "=", "1")
                    ->where('contacto.eliminado', '=', '0')
                    ->get()->toArray();
    
    return $objecto;
    
  }

   
    public function guardarContacto() {
    global $aplicacion;
    $request = new S3Request();
    $variablesPost = $request->obtenerVariables();
    if (isset($variablesPost['cuenta_id2'])){
       $aux = $variablesPost['cuenta_id2'];
       $variablesPost['cuenta_id'] = $aux;
    }
    $this->cargarCampos();
    $bdObjeto = $this;
   
    //Queda por defecto opcion de lista maestra 4 que es 'activo'
    $bdObjeto->estado_id = 4;

    foreach ($variablesPost as $variablePost => $valorPost) {
      if (in_array($variablePost, $this->camposTabla)) {
        $bdObjeto->$variablePost = (empty($valorPost)) ? NULL : $valorPost;
      }
    }
    if (in_array('creado_por', $this->camposTabla)) {
      $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
    }
    if (in_array('fecha_creacion', $this->camposTabla)) {

      $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
    }
    
    $bdObjeto->save();
      
    if (isset($variablesPost['rol_id'])){
        $this->postguardarModal($bdObjeto); 
        }
    else {
        $this->postguardarConvertir($bdObjeto); }
    
  }
  
  protected function preguardar(&$bdObjeto) {
    $post = new S3Request();
    $post = $post->obtenerVariables();
    $fecha = explode('-', $post['fecha_nacimiento']);
    $fecha[0] = 2016;    
    $post['fecha_nacimiento'] = implode('-', $fecha);    
  }
  
  public function obtenerRegistroUltimaAct($registro) {
     $bdObjeto = static::query()
                    ->selectRaw("`contacto`.`id`,`actividad`.`id` AS bandera,IFNULL(`actividad`.`id`,`contacto`.`fecha_creacion`) AS Fecha_inicio, CONCAT( `contacto`.`nombres`,' ',`contacto`.`apellidos` ) AS Nombre_Contacto, CONCAT( `usuario`.`nombres`, ' ', `usuario`.`apellidos` ) AS Nombre_Asesor, `usuario`.`correo`, IFNULL( MAX(`actividad`.`fecha_modificacion`
), MAX(`actividad`.`fecha_creacion`) ) AS Fecha ")
                    ->leftjoin('contacto_actividad', 'contacto.id', '=', 'contacto_actividad.contacto_id')
                    ->leftjoin('actividad', 'contacto_actividad.actividad_id', '=', 'actividad.id')
                    ->leftjoin('usuario', 'contacto.asesor_id', '=', 'usuario.id')
                    ->where('contacto.id', '=', $registro['id'])
                    ->groupBy('contacto.id')->orderBy('actividad.fecha_creacion', 'DESC')
                    ->get()->toArray();
//    __P($bdObjeto[0]);
   
    return $bdObjeto[0];
  }
  
  
}
