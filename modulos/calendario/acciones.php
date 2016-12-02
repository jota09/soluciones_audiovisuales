<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class AccionesCalendario {

    public function accionEditar() {

        global $aplicacion;
        $config = $aplicacion->getConfig();

        $scripts = array(
            'librerias/js/fullcalendar/moment.min.js', 'librerias/js/fullcalendar/fullcalendar.js',
            'librerias/js/fullcalendar/gcal.js', 'librerias/js/fullcalendar/lang/es.js',
            'base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js',
            'assets/js/general/panel_derecho.js', 'assets/js/modulos/calendario/editar.js',
        );
        $estilos = array('librerias/css/fullcalendar/fullcalendar.css',
            'base/librerias/js/select2/select2.css',
            'base/librerias/js/select2/select2-bootstrap.css', 'assets/css/modulos/calendario/calendar.css');

        require_once 'modelo/Cuenta.php';
        require_once 'modelo/Contacto.php';
        require_once 'modelo/Usuario.php';
        $usu = new Usuario();
        $usuarios_actividades = $usu->obtenerUsuariosActividad();
        $cuenta = new Cuenta();
        $cuentas_actividades = $cuenta->obtenerCuentasActividad();
        $contacto = new Contacto();
        $contactos_actividades = $contacto->obtenerContactosActividad();
        $aplicacion->getVista()->assign('cuentas_calendario', $cuentas_actividades);
        $aplicacion->getVista()->assign('contactos_calendario', $contactos_actividades);
        $aplicacion->getVista()->assign('usuarios_calendario', $usuarios_actividades);
        require_once 'modelo/Lista_maestra.php';
        $objListaMaestra = new Lista_maestra();
        $lm_actividades_id = $config->getVariableConfig('aplicacion-relaciones-lm_actividades_id');
        $listas_actividades = $objListaMaestra->obtenerOpcionesPorModulo($lm_actividades_id);
        $aplicacion->getVista()->assign('listas_actividades', $listas_actividades);



        require_once 'modelo/_ModuloRelacion.php';
        $objModulo = new ModuloRelacion();
        $modulos_actividades = $objModulo->obtener_modulos_act();
        $campos = $objModulo->ObtenerRegistrosModulo();
        
        $aplicacion->getVista()->assign('modulos_actividades', $modulos_actividades);
        $aplicacion->getVista()->assign('campos', $campos);
        $aplicacion->getVista()->assign('horas', $this->obtenerHoras());
        $aplicacion->getVista()->assign('minutos', $this->obtenerMinutos());
        $aplicacion->getVista()->assign('scripts', $scripts);
        $aplicacion->getVista()->assign('estilos', $estilos);
        $aplicacion->getVista()->assign('contenidoModulo', 'modulos/calendario/editar');
    }

    public function accionListar() {
        $request = new S3Request();

        $peticion = array(
            'modulo' => 'calendario',
            'accion' => 'editar',
        );

        $request->redireccionar($peticion);
    }

    public function obtenerHoras() {
        for ($h = 1; $h <= 12; $h++) {
            $horas[] = array(
                'hora' => ($h <= 9) ? '0' . $h : $h
            );
        }
        return $horas;
    }

    public function obtenerMinutos() {
        $m = 0;
        for ($h = 0; $h < 4; $h++) {
            $minutos[] = array(
                'minutos' => ($m < 1) ? '0' . $m : $m
            );
            $m += 15;
        }
        return $minutos;
    }

}
