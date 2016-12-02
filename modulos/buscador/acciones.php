<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class AccionesBuscador extends S3Accion {

    public function accionEditar() {
        global $aplicacion;
        $S3Lenguaje = new S3Lenguaje();
        $S3Lenguaje->setLenguaje('es_CO');
        require_once 'modelo/Lista_maestra.php';
        $ListaMaestra = new Lista_maestra();

        $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js', 'assets/js/modulos/' . $this->modulo . '/editar.js');
        $this->estilos = array('base/librerias/js/select2/select2.css', 'base/librerias/js/select2/select2-bootstrap.css', 'assets/css/modulos/' . $this->modulo . '/editar.css');
        $listasG = $ListaMaestra->obtenerOpcionesGeneral();

        $aplicacion->getVista()->assign('listasG', $listasG);
        $aplicacion->getVista()->assign('L_MOD', $S3Lenguaje->getLenguajeModulo('inmuebles'));
        $aplicacion->getVista()->assign('configModulo', $this->confModulo);
        $aplicacion->getVista()->assign('scripts', $this->scripts);
        $aplicacion->getVista()->assign('estilos', $this->estilos);
        $aplicacion->getVista()->assign('contenidoModulo', 'modulos/buscador/editar');
    }

}
