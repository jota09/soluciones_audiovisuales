<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class ClientePotencial_direccion extends S3TablaBD {

    protected $table = 'cliente_potencial_direccion';

    public function borrarDirecciones($idCli) {
        static::query()
                ->where('cliente_potencial_id', '=', $idCli)
                ->delete();
    }

    public function guardar($idCli, $idDir) {
        $data = array(
            "cliente_potencial_id" => $idCli,
            "direccion_id" => $idDir,
            "eliminado" => 0
        );
        static::insert($data);
    }


}
