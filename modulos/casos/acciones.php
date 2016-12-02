<?php

if (!defined('s3_entrada') || !s3_entrada) {
      die('No es un punto de entrada valido');
}

class AccionesCasos extends S3Accion {

      public function accionEditar() {
            parent::accionEditar();
            global $aplicacion;

            require_once 'modelo/Lista_maestra.php';
            require_once 'modelo/Caso.php';
            require_once 'modelo/Caso_actividad.php';
            require_once 'modelo/Servicio.php';

            $caso = new Caso();
            $caso_act = new Caso_actividad();
            $tiempo = new S3Tiempo();
            $request = new S3Request();
            $peticion = $request->obtenerPeticion();
            $ListaMaestra = new Lista_maestra();
            $servicio = new Servicio();
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

            $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js');
            if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
                  $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
            }
            $listasM = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);
            $listasG = $ListaMaestra->obtenerOpcionesGeneral();

            $registro = $caso->obtenerRegistro($peticion['parametros']['registro']);
            $actividades = $caso_act->obtenerListaRegistros();

            $aplicacion->getVista()->assign('scripts', $this->scripts);
            $aplicacion->getVista()->assign('t_transcurrido', $tiempo->tiempoTranscurrido($registro, 'casos'));
            $aplicacion->getVista()->assign('listasM', $listasM);
            $aplicacion->getVista()->assign('actividades', $actividades);
            $aplicacion->getVista()->assign('listasG', $listasG);
            $aplicacion->getVista()->assign('relacionado', $peticion['modulo_id']);
            $aplicacion->getVista()->assign('cuenta', $cuenta->obtenerListaRegistros());
            $aplicacion->getVista()->assign('servicio', $servicio->obtenerListaRegistros());
            $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
            $aplicacion->getVista()->assign('panel_derecho', 'modulos/' . $this->modulo . '/panel_derecho');
      }

      public function accionDetalle() {
            parent::accionEditar();
            global $aplicacion;
            require_once 'modelo/Cuenta.php';
            require_once 'modelo/Usuario.php';
            require_once 'modelo/Lista_maestra.php';
            require_once 'modelo/Caso_actividad.php';

            $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js', 'base/librerias/js/datatables/jquery.dataTables.min.js');
            $this->estilos = array('base/librerias/js/select2/select2.css', 'base/librerias/css/datatables/jquery.dataTables.min.css', 'base/librerias/js/select2/select2-bootstrap.css');
            if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
                  $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
            }

            if (file_exists('assets/css/modulos/' . $this->modulo . '/editar.css')) {
                  $this->estilos[] = 'assets/css/modulos/' . $this->modulo . '/editar.css';
            }

            $cuenta = new Cuenta();
            $usu = new Usuario();

            $request = new S3Request();
            $registriId = $request->obtenerVariablePGR('registro');
            $request = $request->obtenerPeticion();
            $ListaMaestra = new Lista_maestra();
            $caso_actividad = new Caso_actividad();

            $listasM = $ListaMaestra->obtenerOpcionesPorModulo($request['modulo_id']);
            $listasG = $ListaMaestra->obtenerOpcionesGeneral();

            $ver = new S3Ver($this->confModulo['global']['objetoBD']);
            $registro = $ver->obtenerRegistro($this->registro);
//__P($registro);
            $aplicacion->getVista()->assign('horas', $this->obtenerHoras());
            $aplicacion->getVista()->assign('minutos', $this->obtenerMinutos());
            $aplicacion->getVista()->assign('registro', $registro);
            $aplicacion->getVista()->assign('configModulo', $this->confModulo);
            $aplicacion->getVista()->assign('scripts', $this->scripts);
            $aplicacion->getVista()->assign('estilos', $this->estilos);
            $aplicacion->getVista()->assign('listasM', $listasM);
            $aplicacion->getVista()->assign('listasG', $listasG);
            $aplicacion->getVista()->assign('cuentas', $cuenta->obtenerListaRegistros());
            $aplicacion->getVista()->assign('listarActividad', $caso_actividad->obtenerActividadXCaso($registriId));
            $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
            $aplicacion->getVista()->assign('contenidoModulo', 'general/detalle');
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

      function accionGuardarActividad() {

            $request = new S3Request();
            $variablesPost = $request->obtenerVariables();

            require_once 'modelo/Actividades.php';
            $actividades = new Actividades();
            $objActividad = $actividades->guardar();

            require_once 'modelo/Caso_actividad.php';
            $caso_actividad = new Caso_actividad();

            $caso_actividad->guardar($variablesPost['registroId'], $objActividad->id);

            die(json_encode($variablesPost));
      }

      public function accionCasosXModulo() {

            $request = new S3Request();
            $variables = $request->obtenerVariables();

            require_once 'modelo/Caso.php';
            $caso = new Caso();

            $datos = $caso->obtener_relacionados($variables);
            die(json_encode($datos));
      }

      public function accionCrearCasoPanelDerecho() {
            require_once 'modelo/Caso.php';
            $caso = new Caso();
            
            $data = $caso->guardarCasoPanelDerecho();
            die(json_encode($data));
      }

}
