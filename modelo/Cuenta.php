<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Cuenta extends S3TablaBD {

  protected $table = 'cuenta';

  protected function preguardar(&$bdObjeto) {
    $post = new S3Request();
    $post = $post->obtenerVariables();
    $numeroaux = $bdObjeto->cupo_credito;
    $numeroaux *= 1000;
    $bdObjeto->cupo_credito = $numeroaux;
    $numeroaux = $bdObjeto->valor_cartera;
    $numeroaux *= 1000;
    $bdObjeto->valor_cartera = $numeroaux;

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
//    __P($post);
    foreach ($post['telefono_id'] as $k => $v) {
      $tel = new Telefono();
      $tel->guardar($bdObjeto->id, 'Cuenta_telefono', $k);
    }

    foreach ($post['direccion_id'] as $k => $v) {
      $dir = new Direccion();
      $dir->guardar($bdObjeto->id, 'Cuenta_direccion', $k);
    }

    foreach ($post['correo_id'] as $k => $v) {
      $cor = new Correo();
      $cor->guardar($bdObjeto->id, 'Cuenta_correo', $k);
    }
    
    if (!empty($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0) {
            $nomAvatar = $bdObjeto->id;
            $nomAvatar = $nomAvatar . '.' . pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
            $_FILES["avatar"]["name"] = $nomAvatar;
            $avatar = new S3Upload('img_cuenta/');
            $avatar->setExtension(array('jpg', 'png', 'jpeg'));
            $avatar->subirArchivo('avatar', false);
            $bdObjeto->avatar = $nomAvatar;
            $bdObjeto->save();
        }
    
  }
  protected function postguardarConvertir(&$bdObjeto) {

    require_once 'modelo/Telefono.php';
    require_once 'modelo/Direccion.php';
    require_once 'modelo/Correo.php';

    $request = new S3Request();
    $post = $request->obtenerVariables();
//    __P($post);
    foreach ($post['telefono_id'] as $k => $v) {
      $tel = new Telefono();
      $tel->guardarConvertir($bdObjeto->id, 'Cuenta_telefono', $k);
    }

    foreach ($post['direccion_id'] as $k => $v) {
      $dir = new Direccion();
      $dir->guardarConvertir($bdObjeto->id, 'Cuenta_direccion', $k);
    }

    foreach ($post['correo_id'] as $k => $v) {
      $cor = new Correo();
      $cor->guardarConvertir($bdObjeto->id, 'Cuenta_correo', $k);
    }
  }
  
  protected function prelistar(&$bdObjeto) {
      $bdObjeto = static::query()
            ->leftjoin('opcion_lista_maestra AS olm_t', 'olm_t.id', '=', 'cuenta.tipo_documento_id')
            ->leftjoin('opcion_lista_maestra AS olm_n', 'olm_n.id', '=', 'cuenta.naturaleza_id')
            ->leftjoin('opcion_lista_maestra AS olm', 'olm.id', '=', 'cuenta.estado_id')
            ->leftjoin('opcion_lista_maestra AS olmT', 'olmT.id', '=', 'cuenta.tipo_cuenta_id')
            ->leftjoin('opcion_lista_maestra AS olmS', 'olmS.id', '=', 'cuenta.segmento_id')
            ->leftjoin('opcion_lista_maestra AS olmC', 'olmC.id', '=', 'cuenta.clasificacion_id')
            ->selectRaw("cuenta.id ,TRIM(CONCAT(IFNULL(cuenta.nombres,cuenta.nombre_comercial),' ',IFNULL(cuenta.apellidos,''))) AS nombres, olm_n.nombre  AS naturaleza, olm_t.nombre  AS tipo_documento,  olm.nombre as estado, olmC.nombre as clasificacion, olmT.nombre as 'tipo cuenta',  cuenta.num_documento, olmS.nombre as segmento , cuenta.activo ");
   }

  
  public function obtenerListaRegistrosDispobible($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

    $this->cargarCampos();
    $bdObjeto = static::query()
            ->selectRaw("cuenta.id, cuenta.cupo_credito , cuenta.valor_cartera");
    if ($only) {
      $bdObjeto->take(1)->skip(0);
    }
    $bdObjeto->orderBy($this->table . '.id', 'DESC');
    $arrayCli = $bdObjeto->get()->toArray();
   for ($i = 0; $i < count($arrayCli); $i++) {
          $arrayCli[$i]['disponible'] = (($arrayCli[$i]['cupo_credito'] * 0.6) - $arrayCli[$i]['valor_cartera']);}
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

      $reg['telefonos'] = $objTel->obtenerTelefonoXModulo($registro, "cuenta");
      $reg['direcciones'] = $objDir->obtenerDireccionXModulo($registro, "cuenta");
      $reg['correos'] = $objCorreo->obtenerCorreoXModulo($registro, "cuenta");
    }

    $reg_ubicacion = $objViewUbicacion->obtenerRegistro($reg['view_ubicacion_id']);
    $reg['view_ubicacion_nombre'] = $reg_ubicacion['ubicacion'];
    return $reg;
  }

  public function obtenerClientes() {

    return static::query()
                    ->selectRaw("cuenta.id, IF(cuenta.`naturaleza_id` = 33 , cuenta.`razon_social`, CONCAT(cuenta.nombres, ' ', cuenta.apellidos) ) AS nombre")
                    ->where('cuenta.eliminado', '=', '0')
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

  public function convertirCuenta($informacion) {
    global $aplicacion;
    $this->cargarCampos();

    $variablesPost = $informacion;
    $bdObjeto = $this;
    foreach ($variablesPost as $variablePost => $valorPost) {
      if (in_array($variablePost, $this->camposTabla)) {
        $bdObjeto->$variablePost = (empty($valorPost)) ? NULL : $valorPost;
      }
    }

    $bdObjeto->nombres = NULL;
    $bdObjeto->apellidos = NULL;
    $bdObjeto->naturaleza_id = 33;
    $bdObjeto->tipo_documento_id = 35;
    $bdObjeto->asesor_asignado_id = $variablesPost['asesor_id'];
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

  public function obtenerCuentasActividad() {
    
    $objecto = static::query()
                    ->selectRaw("cuenta.id ,TRIM(CONCAT(IFNULL(cuenta.nombres,cuenta.nombre_comercial),' ',IFNULL(cuenta.apellidos,''))) AS nombre, c.correo")
                    ->join("cuenta_correo as cc", "cc.cuenta_id", "=", "cuenta.id")
                    ->join("correo as c", "c.id", "=", "cc.correo_id")
                    ->where("c.principal", "=", "1")
                    ->where('cuenta.eliminado', '=', '0')
                    ->get()->toArray();
    
    return $objecto;
    
  }
  
  
}