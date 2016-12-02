<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Contrasenia extends S3TablaBD {

    protected $table = 'contrasenia';

    public function eliminarxUsuario($perf_id) {
        static::query()
                ->where('usuario_id', '=', $perf_id)
                ->delete();
    }

    public function guardar($usuarioId, $contrasenia) {
        global $aplicacion;

        $salt_hash = $aplicacion->getConfig()->getVariableConfig('aplicacion-salthash');

        $data = array(
            "hash" => sha1(base64_encode(md5($contrasenia) . $salt_hash)),
            "usuario_id" => $usuarioId,
            "eliminado" => 0
        );
        static::insert($data);
    }

}
