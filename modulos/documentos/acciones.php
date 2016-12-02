<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class AccionesDocumentos extends S3Accion {

  public function accionEditar() {
    parent::accionEditar();
    global $aplicacion;


    require_once 'modelo/Usuario.php';
    require_once 'modelo/Lista_maestra.php';
    require_once 'modelo/Documentos.php';
    require_once 'modelo/Revision.php';
    require_once 'modelo/_ModuloRelacion.php';

    $objModulo = new ModuloRelacion();
    $modulos_documentos = $objModulo->obtener_modulos();

    $u = new Usuario();
    $usuarios = $u->obtenerListaRegistros();
    $ListaMaestra = new Lista_maestra();
    $request = new S3Request();
//    $rel = new Documentos();

    $revisiones = new Revision();
    $revs = $revisiones->ObtenerRevisionesxDocumento($request->obtenerVariablePGR('registro'));


    $peticion = $request->obtenerPeticion();
    $listas = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);


    $campos = $objModulo->ObtenerRegistrosModulo();


//    $relacionado = array();
//    $relacionado['registro'] = array();

//    foreach ($modulos_documentos as $key => $val) {
//
//      $relacionado['registro'] = array_merge($relacionado['registro'], $rel->obtener_registros_modulo_relacionado($val['id'], $val['tabla'], $campos[$key]));
//    }

    $count = count($revs);
    $aplicacion->getVista()->assign('campos', $campos);
    $aplicacion->getVista()->assign('listas', $listas);
//    $aplicacion->getVista()->assign('relacionado', $relacionado['registro']);
    $aplicacion->getVista()->assign('modulos_documentos', $modulos_documentos);
    $aplicacion->getVista()->assign('revs', $revs);
    $aplicacion->getVista()->assign('docs', $count);
    $aplicacion->getVista()->assign('usuarios', $usuarios);
  }

  public function accionCrear_revision() {
    global $aplicacion;
    require_once 'modelo/Revision.php';
    $user = $aplicacion->getUsuario()->getId();
    $revision = new Revision();
    $datos = $revision->crear_revision($user);
    die(json_encode($datos));
  }

  public function accionCrear_documento() {

    global $aplicacion;
    require_once 'modelo/Documentos.php';
    $user = $aplicacion->getUsuario()->getId();
    $documento = new Documentos();
    $datos = $documento->crear_documento($user);
    die(json_encode($datos));
  }

  public function accionObtener_revisiones() {
    require_once 'modelo/Revision.php';
    $revisiones = new Revision();
    $revs = $revisiones->ObtenerRevisionesxDocumento($_POST['id']);
    die(json_encode($revs));
  }

  public function accionQuitar_documento() {
    require_once 'modelo/Documentos.php';
    $documentos = new Documentos();
    $x = $documentos->eliminar_documento($_POST['id']);
    die(json_encode($x));
  }

  public function accionObtener_documentos() {

    require_once 'modelo/Documentos.php';
    $documentos = new Documentos();

    $request = new S3Request();
    $variables = $request->obtenerVariables();

    $datos = $documentos->obtener_relacionados($variables);
    die(json_encode($datos));
  }

}
