<?php

if (!defined('s3_entrada') || !s3_entrada) {
   die('No es un punto de entrada valido');
}

class AccionesHome extends S3Accion {

   public function accionInicio() {
      global $aplicacion;

      $request = new S3Request();

      if ($aplicacion->getUsuario()->getAdmin()) {
         $peticion = array(
             'modulo' => 'home',
             'accion' => 'administrador'
         );
      } else {
         $rol = $aplicacion->getUsuario()->getPerfil();
         switch ($rol) {
            default:
               $peticion = array(
                   'modulo' => 'home',
                   'accion' => 'administrador'
               );
               break;
         }
      }

      $request->redireccionar($peticion);
   }

   public function accionAdministrador() {

      global $aplicacion;
      $config = $aplicacion->getConfig();
      require_once 'modelo/Actividades.php';
      require_once 'modelo/Oportunidad.php';
      require_once 'modelo/Lista_maestra.php';
      require_once 'modelo/Usuario.php';
      $usu = new Usuario();
      $ListaMaestra = new Lista_maestra();

      $objActividad = new Actividades();
      $objOportunidad = new Oportunidad();

      $this->scripts = array('base/librerias/js/select2/select2.min.js', 'base/librerias/js/datatables/jquery.dataTables.min.js', 'assets/js/modulos/' . $this->modulo . '/administracion.js');

      $this->estilos = array('base/librerias/css/datatables/jquery.dataTables.min.css', 'base/librerias/js/select2/select2.css', 'base/librerias/js/select2/select2-bootstrap.css');

      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('estilos', $this->estilos);

      $lm_actividades_id = $config->getVariableConfig('aplicacion-relaciones-lm_actividades_id');
      $listas_actividades = $ListaMaestra->obtenerOpcionesPorModulo($lm_actividades_id);
      $listasM = $ListaMaestra->obtenerOpcionesPorModulo(5);

      $aplicacion->getVista()->assign('listas_actividades', $listas_actividades);
      $aplicacion->getVista()->assign('mis_actividades', $objActividad->misActividadesPendientes());
      $aplicacion->getVista()->assign('mis_oportunidades', $objOportunidad->misNegociaciones());
      $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
      $aplicacion->getVista()->assign('listasM', $listasM);
      $aplicacion->getVista()->assign('contenidoModulo', "general/administracion");
   }

   /* public function accionDefault() {
     global $aplicacion;
     $config = $aplicacion->getConfig();
     $this->scripts = array('base/librerias/js/select2/select2.min.js', 'base/librerias/js/datatables/jquery.dataTables.min.js', 'assets/js/modulos/' . $this->modulo . '/administracion.js');

     $this->estilos = array('base/librerias/css/datatables/jquery.dataTables.min.css', 'base/librerias/js/select2/select2.css', 'base/librerias/js/select2/select2-bootstrap.css');

     $aplicacion->getVista()->assign('scripts', $this->scripts);
     $aplicacion->getVista()->assign('estilos', $this->estilos);

     require_once 'modelo/Actividades.php';
     require_once 'modelo/Oportunidad.php';
     require_once 'modelo/Lista_maestra.php';
     $objListaMaestra = new Lista_maestra();

     $objActividad = new Actividades();
     $objOportunidad = new Oportunidad();

     $lm_actividades_id = $config->getVariableConfig('aplicacion-relaciones-lm_actividades_id');
     $listas_actividades = $objListaMaestra->obtenerOpcionesPorModulo($lm_actividades_id);
     $aplicacion->getVista()->assign('listas_actividades', $listas_actividades);
     $aplicacion->getVista()->assign('mis_actividades', $objActividad->misActividadesPendientes());
     $aplicacion->getVista()->assign('mis_negociaciones', $objOportunidad->misNegociaciones());
     $aplicacion->getVista()->assign('asesores', $usu->obtenerListaRegistros());
     $aplicacion->getVista()->assign('contenidoModulo', "general/administracion");
     } */

   public function menu_frecuentes() {
      $menu_frecuentes = Spyc::YAMLLoad('config/menu/frecuentes.es_CO.yml');

      foreach ($menu_frecuentes as $menu => $item) {
         $lista .= '<li><a href="index.php?modulo=' . $item['modulo'] . '&accion=' . $item['accion'] . '" >' . $menu . '</a></li>';
      }
      return $lista;
   }

   public function accionAlertaCalendario() {
      require_once 'modelo/Actividades.php';
      $actividad = new Actividades();
      $generarAlertas = array(); //$actividad->alertaCalendario();
      //__P($generarAlertas);

      die(json_encode($generarAlertas));
   }

}
