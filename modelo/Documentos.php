<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Documentos extends S3TablaBD {

  protected $table = 'documento';

  public function postguardar(&$bdObjeto) {
    parent::postguardar($bdObjeto);

    require_once 'modelo/Revision.php';

    $nombre_adjunto = $_FILES["adjunto"]["name"];
    $nombre = $bdObjeto->id;
    $_FILES["adjunto"]["name"] = $nombre . '_' . $_FILES["adjunto"]["name"];
    $adjuntos = new S3Upload('adjuntos/');
    $adjuntos->setExtension(array('pdf', 'xls', 'xlsx', 'doc', 'docx', 'txt'));
    $x = $adjuntos->subirArchivo('adjunto', false);
    $stri = $x['success']['url'];
//        echo $stri;
//        die();
    $n = explode("/", $stri);

    $fecha = date('Y-m-d');
    if ($n[2] != '') {
      $bdObjeto->adjunto = $n[2];
      $bdObjeto->nombre_adjunto = $nombre_adjunto;
      Revision::insert(array(
          'bandera' => '1',
          'documentos_id' => $bdObjeto->id,
          'nombre' => $bdObjeto->nombre,
          'adjunto' => $bdObjeto->adjunto,
          'nombre_adjunto' => $bdObjeto->nombre_adjunto,
          'version' => $bdObjeto->version,
          'creado_por' => $bdObjeto->creado_por,
          'fecha_creacion' => $fecha,
          'descripcion' => $bdObjeto->descripcion,
      ));
    }

    $bdObjeto->save();
  }

//traer los documentos por modulo y id
  public function obtener_relacionados($parametros) {


    if ($parametros['modulo_name'] == 'cuentas') {
      $mdl = "cuenta";
    } else if ($parametros['modulo_name'] == 'acuerdos') {
      $mdl = "acuerdo";
    } else if ($parametros['modulo_name'] == 'casos') {
      $mdl = "caso";
    } else if ($parametros['modulo_name'] == 'clientes_potenciales') {
      $mdl = "cliente_potencial";
    } else if ($parametros['modulo_name'] == 'contactos') {
      $mdl = "contacto";
    } else if ($parametros['modulo_name'] == 'oportunidades') {
      $mdl = "oportunidad";
    } else if ($parametros['modulo_name'] == 'cotizaciones') {
      $mdl = "cotizacion";
    } else if ($parametros['modulo_name'] == 'servicios') {
      $mdl = "servicio";
    } else if ($parametros['modulo_name'] == 'convenios') {
      $mdl = "convenio";
    }

    $bdObjeto = static::query()
            ->selectRaw("documento.*")
            ->join($mdl . "_documento as ca", "ca.documento_id", "=", "documento.id")
            ->whereRaw('ca.' . $mdl . '_id = ' . $parametros['modulo_id'])
            ->where('ca.eliminado', '=', '0')
            ->where('documento.eliminado', '=', '0')
            ->orderBy('documento.id', 'DESC')
            ->get();

    $lista = $bdObjeto->toArray();
    $tmp = Array();
    //preformatea lo que se va a imprimir
    for ($i = 0; $i < count($lista); $i++) {
      $tmp[$i]['id'] = $lista[$i]['id'];
      $tmp[$i]['adjunto'][] = $lista[$i]['adjunto'];
      $tmp[$i]['adjunto'][] = $lista[$i]['nombre_adjunto'];
      $tmp[$i]['nombre'] = $lista[$i]['nombre'];
      $tmp[$i]['eliminado'] = '<i class=" fa fa-minus"></i>';
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
            'data' => 'adjunto',
            'mData' => 'adjunto'
        ),
        '2' => Array
            (
            'data' => 'nombre',
            'mData' => 'nombre'
        ),
        '3' => Array
            (
            'data' => 'eliminado',
            'mData' => 'eliminado'
        )
    );

    $k = 0;
    $array['count_doc'] = count($tmp);
    $array['docs'] = $tmp;
    //columnas
//        foreach ($tmp[0] as $key => $value) {
//            $array['campos'][$k]['data'] = $key;
//            $array['campos'][$k]['mData'] = $key;
//            $k++;
//        }
//        __P($array['campos']);
    return $array;
  }

//traer los registros para cada modulo
  public function obtener_registros_modulo_relacionado($modulo_id, $tabla, $campos) {

    $count = count($campos[0]);
    if ($count < 2) {
      $field = $campos[0][0];
    }
    if ($count > 1) {
      $field = ' concat(' . $campos[0][0] . ', ' . $campos[0][1] . ') '; //CONCAT(Nombre, ' ', Apellidos) As Nombre 
    }

    $lista = array();
    $bdObjeto = static::hydrateRaw(' select ' . $field . ' as nombre_general, id from ' . $tabla . ' 
                        where eliminado="0" and activo ="1" ');
    $lista = $bdObjeto->toArray();

//             
    for ($i = 0; $i < count($lista); $i++) {
      $lista[$i]['modulo_id'] = $modulo_id;
    }

    return $lista;
  }

  public function actualizar_documento($id, $version, $adjunto, $nombre_adjunto) {
    $bdObjeto = static::query()
            ->where('id', '=', $id)
            ->update(array('version' => $version, 'adjunto' => $adjunto, 'nombre_adjunto' => $nombre_adjunto)
    );
  }

  public function eliminar_documento($id) {


    $bdObjeto = static::query()
            ->where('id', '=', $id)
            ->update(array('eliminado' => 1)
    );

    require_once 'modelo/Revision.php';
    $revision = new Revision();
    $revision->quitar_revisionesxdocumento($id);
    die(json_encode('1'));
  }

  public function crear_documento($user) {

    $_FILES["adjunto"]["name"] = str_replace(" ", "_", $_FILES["adjunto"]["name"]);

    $adjuntos = new S3Upload('adjuntos/');

    $x = $adjuntos->subirArchivo('adjunto', false);
    // URL => uploads/adjuntos/Bugs_Soluciones_Audiovisuales_080716.docx
    $stri = $x['success']['url'];
    $n = explode("/", $stri);
    $fecha = date('Y-m-d');
//__P($_POST);

    if ($n[2] != '') {
      require_once 'modelo/Revision.php';
      $adjunto = $n[2];
      $documentoId = Documentos::insertGetId(array(
                  'nombre' => $_POST['nombre'],
                  'tipo_documento' => $_POST['tipo_documento'],
                  'modulo_relacionado' => $_POST['modulo_relacionado'],
                  'modulo_relacionado_id' => $_POST['modulo_relacionado_id_nuevo'],
                  'version' => $_POST['version'],
                  'adjunto' => $adjunto,
                  'nombre_adjunto' => $_FILES["adjunto"]["name"],
                  'categoria' => $_POST['categoria'],
                  'estado' => $_POST['estado'],
                  'fecha_publicacion' => date('Y-m-d H:i:s'),
                  'descripcion' => $_POST['descripcion'],
                  'creado_por' => $user,
      ));

      $_POST['relacionado'] = $_POST['modulo_relacionado'];
      $_POST['relacionado_id'] = $_POST['modulo_relacionado_id_nuevo'];
      $this->guardarRelaciones($_POST, $documentoId);

      Revision::insert(array(
          'bandera' => '1',
          'documentos_id' => $documentoId,
          'nombre' => $nombre,
          'adjunto' => $adjunto,
          'version' => $_POST['version'],
          'creado_por' => $user,
          'fecha_creacion' => $fecha,
          'descripcion' => $_POST['descripcion'],
      ));
    } else {
      die(json_encode('0'));
    }

    die(json_encode('1'));
  }

  public function prelistar(&$bdObjeto) {
    parent::prelistar($bdObjeto);
//        $bdObjeto->selectRaw('documento.*');
//                ->leftJoin('tipo_ubicacion', 'ubicacion.tipo_ubicacion_id', '=', 'tipo_ubicacion.id');
//                ->Join('opcion_lista_maestra AS lista_doc', 'tipo_mascota.id', '=', 'raza.tipo_mascota_id');
  }

  public function postObtenerListaRegistrosAjaxTabla(&$listaRegistros) {
    $tmp = $listaRegistros;
    for ($i = 0; $i < count($tmp); $i++) {
      $listaRegistros[$i]['checkbox'] = '<label><input type="checkbox" name="id[]" value="' . $listaRegistros[$i]['id'] . '" class="minimal-red"></label>';
      $listaRegistros[$i]['modulo_relacionado'] = $this->obtener_modulo($tmp[$i]['modulo_relacionado']);
      $listaRegistros[$i]['modulo_relacionado_id'] = $this->obtener_modulo_registro($tmp[$i]['modulo_relacionado_id'], $listaRegistros[$i]['modulo_relacionado'], $_REQUEST['modulo']);
      $listaRegistros[$i]['creado_por'] = $this->obtener_usuario($tmp[$i]['creado_por']);
    }
    parent::postObtenerListaRegistrosAjaxTabla($listaRegistros);
  }

  public function obtener_modulo($id_modulo) {

    require_once 'modelo/_ModuloRelacion.php';
    $modulo = new ModuloRelacion();
    $datos = $modulo->obtenerRegistro($id_modulo);
    return $datos['nombre'];
  }

  public function obtener_modulo_registro($id_registro, $modulo_relacionado, $modulop) {

    $configModulo = Spyc::YAMLLoad('modulos/' . $modulo_relacionado . '/config.yml');
    $count = count($configModulo['global']['nombre_general']);
    if ($count < 2) {
      $field = $configModulo['global']['nombre_general'][0];
    }
    if ($count > 1) {
      $field = ' concat(' . $configModulo['global']['nombre_general'][0] . ', ' . $configModulo['global']['nombre_general'][1] . ') '; //CONCAT(Nombre, ' ', Apellidos) As Nombre 
    }
    $relaciones = Spyc::YAMLLoad('config/config.yml');
    $tabla = $relaciones['aplicacion']['relaciones'][$modulop][$modulo_relacionado];
    $lista = array();
    $bdObjeto = static::hydrateRaw(' select ' . $field . ' as nombre_general, id from ' . $tabla['tabla'] . ' 
                       where eliminado="0" and activo ="1" and id ="' . $id_registro . '"  ');
    $lista = $bdObjeto->toArray();
    return $lista[0]['nombre_general'];
  }

  public function obtener_usuario($id) {
    require_once 'modelo/Usuario.php';
    $modulo = new Usuario();
    $datos = $modulo->obtenerRegistro($id);
    return $datos['nombre_usuario'];
  }

  public function obtenerXrelacionId($id) {
    return static::query()
//                        ->selectRaw('documento.*')
//                        ->leftjoin('opcion_lista_maestra as tipo_actividad', 'tipo_actividad.id', '=', 'documento.tipo')
                    ->where('documento.modulo_relacionado_id', '=', $id)
                    ->where('documento.eliminado', '=', 0)
                    ->where('documento.activo', '=', 1)
                    ->get()->toArray();
  }

  private function guardarRelaciones($post, $documentoId) {

    if ($post['modulo_relacionado'] == 12) { // CUENTA
      require_once 'modelo/Cuenta_documento.php';
      $cuenta_act = new Cuenta_documento();
      $cuenta_act->guardar($post['modulo_relacionado_id_nuevo'], $documentoId);
    }
    if ($post['modulo_relacionado'] == 5) { // Oportunidad
      require_once 'modelo/Oportunidad_documento.php';
      $oportunidada_act = new Oportunidad_documento();
      $oportunidada_act->guardar($post['modulo_relacionado_id_nuevo'], $documentoId);
    }
    if ($post['modulo_relacionado'] == 22) { // Contacto
      require_once 'modelo/Contacto_documento.php';
      $contacto_act = new Contacto_documento();
      $contacto_act->guardar($post['modulo_relacionado_id_nuevo'], $documentoId);
    }
    if ($post['modulo_relacionado'] == 25) { // ACUERDO
      require_once 'modelo/Acuerdo_documento.php';
      $acuerdo_act = new Acuerdo_documento();
      $acuerdo_act->guardar($post['modulo_relacionado_id_nuevo'], $documentoId);
    }
    if ($post['modulo_relacionado'] == 14) { // CASOS
      require_once 'modelo/Caso_documento.php';
      $caso_act = new Caso_documento();
      $caso_act->guardar($post['modulo_relacionado_id_nuevo'], $documentoId);
    }
    if ($post['modulo_relacionado'] == 7) { // Cliente POtencial
      require_once 'modelo/ClientePotencial_documento.php';
      $cliente_act = new ClientePotencial_documento();
      $cliente_act->guardar($post['modulo_relacionado_id_nuevo'], $documentoId);
    }
    if ($post['relacionado'] == 30) { // SERVICIO
      require_once 'modelo/Servicio_documento.php';
      $acuerdo_act = new Servicio_documento();
      $acuerdo_act->guardar($post['modulo_relacionado_id_nuevo'], $documentoId);
    }
    if ($post['relacionado'] == 29) { // ACUERDO
      require_once 'modelo/Convenio_documento.php';
      $acuerdo_act = new Convenio_documento();
//      __P($post);
      $acuerdo_act->guardar($post['modulo_relacionado_id_nuevo'], $documentoId);
    }
  }

}
