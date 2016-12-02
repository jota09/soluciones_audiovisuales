<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class AccionesProductos extends S3Accion {

  public function accionEditar() {
    parent::accionEditar();
    global $aplicacion;
    $request = new S3Request();
    $request = $request->obtenerPeticion();
    require_once 'modelo/Lista_maestra.php';
    require_once 'modelo/View_categoria.php';

    $ListaMaestra = new Lista_maestra();
    $categoria = new View_categoria();

    $listasM = $ListaMaestra->obtenerOpcionesPorModulo($request['modulo_id']);
    $listasG = $ListaMaestra->obtenerOpcionesGeneral();

    if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
    }

    $aplicacion->getVista()->assign('scripts', $this->scripts);
    $aplicacion->getVista()->assign('estilos', $this->estilos);
    $aplicacion->getVista()->assign('listasG', $listasG);
    $aplicacion->getVista()->assign('categoria', $categoria->obtenerListaRegistros());
    $aplicacion->getVista()->assign('listasM', $listasM);
  }

  public function accionDetalle() {
    parent::accionEditar();
    global $aplicacion;
    $request = new S3Request();
    $registriId = $request->obtenerVariablePGR('registro');
    $request = $request->obtenerPeticion();
    require_once 'modelo/Usuario.php';
    require_once 'modelo/Moneda.php';
    require_once 'modelo/Cliente.php';
    require_once 'modelo/Lista_maestra.php';
    require_once 'modelo/Oportunidad_actividad.php';

    $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js', 'base/librerias/js/datatables/jquery.dataTables.min.js');
    $this->estilos = array('base/librerias/js/select2/select2.css', 'base/librerias/css/datatables/jquery.dataTables.min.css', 'base/librerias/js/select2/select2-bootstrap.css');
    if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
    }

    if (file_exists('assets/css/modulos/' . $this->modulo . '/editar.css')) {
      $this->estilos[] = 'assets/css/modulos/' . $this->modulo . '/editar.css';
    }

    $u = new Usuario();
    $m = new Moneda();
    $c = new Cliente();
    $oportunidad_actividad = new Oportunidad_actividad();

    $ListaMaestra = new Lista_maestra();
    $listasM = $ListaMaestra->obtenerOpcionesPorModulo($request['modulo_id']);
    $listasG = $ListaMaestra->obtenerOpcionesGeneral();

    $aplicacion->getVista()->assign('horas', $this->obtenerHoras());
    $aplicacion->getVista()->assign('minutos', $this->obtenerMinutos());
    $aplicacion->getVista()->assign('scripts', $this->scripts);
    $aplicacion->getVista()->assign('estilos', $this->estilos);
    $aplicacion->getVista()->assign('asesores', $u->obtenerListaRegistros());
    $aplicacion->getVista()->assign('moneda', $m->obtenerListaRegistros());
    $aplicacion->getVista()->assign('cliente', $c->obtenerListaRegistros());
    $aplicacion->getVista()->assign('listarActividad', $oportunidad_actividad->obtenerActividadXOportunidad($registriId));
    $aplicacion->getVista()->assign('toma_contacto', $listasG['toma_de_contacto']);
    $aplicacion->getVista()->assign('etapa', $listasM['etapas_oportunidad']);
    $aplicacion->getVista()->assign('contenidoModulo', 'general/detalle');
  }

  public function accionObtenerProductosXNombre() {

    require_once 'modelo/Producto.php';
    $producto = new Producto();

    die(json_encode($producto->ObtenerProductosXNombre()));
  }
  
  public function accionObtenerProductos() {

            $request = new S3Request();
            $variables = $request->obtenerVariables();

            require_once 'modelo/Producto.php';
            $producto = new Producto();
            $datos = $producto->obtener_relacionados($variables);
            die(json_encode($datos));
      }
}
