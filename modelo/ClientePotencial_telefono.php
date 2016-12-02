<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class ClientePotencial_telefono extends S3TablaBD {

    protected $table = 'cliente_potencial_telefono';

    public function borrarTelefonos($idCli) {
        static::query()
                ->where('cliente_potencial_id', '=', $idCli)
                ->delete();
    }

    public function guardar($idCli, $idTel) {
        $data = array(
            "cliente_potencial_id" => $idCli,
            "telefono_id" => $idTel,
            "eliminado" => 0
        );
        static::insert($data);
    }


}
