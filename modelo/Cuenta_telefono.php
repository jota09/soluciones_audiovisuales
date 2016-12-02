<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Cuenta_telefono extends S3TablaBD {

    protected $table = 'cuenta_telefono';

    public function borrarTelefonos($idCli) {
        static::query()
                ->where('cuenta_id', '=', $idCli)
                ->delete();
    }

    public function guardar($idCli, $idTel) {
        $data = array(
            "cuenta_id" => $idCli,
            "telefono_id" => $idTel,
            "eliminado" => 0
        );
        static::insert($data);
    }


}
