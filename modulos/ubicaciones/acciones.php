
<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class AccionesUbicaciones extends S3Accion {

    public function accionAutocompletar() {
        require_once 'modelo/View_ubicacion.php';
        $request = new S3Request();
        $get['palabra'] = $request->obtenerVariablePGR('palabra');
        $objView_ubicacion = new View_ubicacion();
        die(json_encode($objView_ubicacion->obtenerListaRegistros($get['palabra'])));
    }

    public function accionEditar() {
        parent::accionEditar();
        global $aplicacion;

        $this->scripts = array('assets/js/modulos/ubicaciones/editar.js');
        
        require_once 'modelo/TipoUbicacion.php';
        $objTipoUbic = new TipoUbicacion();
        //__P($objTipoUbic);
        require_once 'modelo/Ubicacion.php';
        $objUbicacion = new Ubicacion();
//        __P($objUbicacion->obtenerListaRegistrosTabla());
        $aplicacion->getVista()->assign('scripts', $this->scripts);
        $aplicacion->getVista()->assign('tipo_ubicaciones', $objTipoUbic->obtenerListaRegistros());
        $aplicacion->getVista()->assign('ubicaciones', $objUbicacion->obtenerListaRegistrosTabla());
    }

    public function accionSegmentarUbicacion(){
        $request = new S3Request();
        $tipo_ubicacion = $request->obtenerVariablePGR('tipo_ubicacion');
        $tipo_ubicacion = empty($tipo_ubicacion) ? 0 : $tipo_ubicacion;
        require_once 'modelo/Ubicacion.php';
        $objUbicacion = new Ubicacion();
        
        $ubicaciones = $objUbicacion->segmentarUbicacion($tipo_ubicacion);
        die(json_encode($ubicaciones));
        
    }

}
