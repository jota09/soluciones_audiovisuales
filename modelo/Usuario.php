<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Usuario extends S3TablaBD {

    protected $table = "usuario";

    protected function postguardar(&$bdObjeto) {
        parent::postguardar($bdObjeto);
        require_once 'modelo/_Contrasenia.php';
        $objContrasenia = new Contrasenia();

        $request = new S3Request();
        $vars = $request->obtenerVariables();
        if (!empty($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0) {
            $nomAvatar = $bdObjeto->nombre_usuario . '_' . $bdObjeto->id;
            $nomAvatar = $nomAvatar . '.' . pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
            $_FILES["avatar"]["name"] = $nomAvatar;
            $avatar = new S3Upload('img_usuario/');
            $avatar->setExtension(array('jpg', 'png', 'jpeg'));
            $avatar->subirArchivo('avatar', false);
            $bdObjeto->avatar = $nomAvatar;
            $bdObjeto->save();
        }

        if (isset($vars['contrasenia']) && isset($vars['contrasenia2']) && !empty($vars['contrasenia']) && !empty($vars['contrasenia2'])) {
            $objContrasenia->eliminarxUsuario($bdObjeto->id);
            $objContrasenia->guardar($bdObjeto->id, $vars['contrasenia']);
        }
    }

    public function setExtras($bdUsuario) {
        $this->avatar = $bdUsuario['avatar'];
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function obtenerUsuariosActividad() {
        return static::query()
                        ->selectRaw("usuario.id, concat(usuario.nombres, ' ', usuario.apellidos) as nombre, usuario.correo")
                        ->where('usuario.eliminado', '=', '0')
                        ->get()->toArray();
    }

    public function obtenerUsuarios() {
        return static::query()
                        ->selectRaw("usuario.id, concat(usuario.nombres, ' ', usuario.apellidos) as nombre, usuario.correo")
                        ->where('usuario.eliminado', '=', '0')
                        ->get()->toArray();
    }

    public function atualizaAutenticacion($id) {
        if ($id > 0) {
            $objUsuario = Usuario::find($id);
            $objUsuario->autenticado = 1;
            $objUsuario->save();
        }
    }

    public function desAutenticacion() {
        $session = new S3Session();
        $usuarioId = $session->getVariable('usuario_id');
        if ($usuarioId > 0) {
            $objUsuario = Usuario::find($usuarioId);
            $objUsuario->autenticado = 0;
            //$objUsuario->save();
            $session->limpiar();
        }
    }

    protected function prelistar(&$bdObjeto) {
        $bdObjeto->selectRaw("usuario.`id`, usuario.`numero_documento`,usuario.`nombres`,usuario.`apellidos`,usuario.`nombre_usuario`,IF(usuario.`administrador` = 1, 'Si','No') As admin,usuario.`fecha_creacion`,usuario.`celular_contacto`,usuario.`correo` as correo");
    }
}
