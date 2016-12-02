<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class AccionesUsuarios extends S3Accion {

  public function accionAutenticar() {
    global $aplicacion;

    $config = $aplicacion->getConfig()->getConfigApp();
    $request = new S3Request();
    $vars = $request->obtenerVariables();

    $loginUsuario = $vars['login_usuario'];
    $loginContrasenia = $vars['login_contrasenia'];

    $usuario = $aplicacion->getUsuario();
    $usuario->autenticar($loginUsuario, $loginContrasenia);

    if ($usuario->estaAutenticado()) {
      $aplicacion->getSession()->setVariable('usuario_id', $usuario->getId());
      $modulo = $config['aplicacion']['modulo_predeterminado'];
      $accion = $config['aplicacion']['accion_predeterminado'];

      $peticion = array(
          'modulo' => $modulo,
          'accion' => $accion
      );

      $request->redireccionar($peticion);
    }
  }

  public function accionLogin() {
    global $aplicacion;
    require_once 'modelo/Usuario.php';
    $objUsuario = new Usuario();
    $objUsuario->desAutenticacion();
    $aplicacion->getVista()->draw('login');
  }

  public function accionLogout() {
    global $aplicacion;
    $aplicacion->getUsuario()->desAutenticacion();
  }

  public function accionEditar() {
    parent::accionEditar();
    global $aplicacion;
    $tiempo = new S3Tiempo();
    $request = new S3Request();
    $peticion = $request->obtenerPeticion();
    require_once 'modelo/Perfil.php';
    $objPerfil = new Perfil();
    require_once 'modelo/Lista_maestra.php';
    $ListaMaestra = new Lista_maestra();
    $listasM = $ListaMaestra->obtenerOpcionesPorModulo($peticion['modulo_id']);

    require_once 'modelo/Usuario.php';
    $usuario = new Usuario();
    $registro = $usuario->obtenerRegistro($peticion['parametros']['registro']);
    
    if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
    }

    $scripts = array_merge($this->scripts, $this->scripts);

    $aplicacion->getVista()->assign('t_transcurrido', $tiempo->tiempoTranscurrido($registro, 'usuarios'));
    $aplicacion->getVista()->assign('panel_derecho', 'modulos/' . $this->modulo . '/panel_derecho');
    
    $aplicacion->getVista()->assign('listasM', $listasM);
    $aplicacion->getVista()->assign('perfiles', $objPerfil->obtenerListaRegistros());
  }

}
