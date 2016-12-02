<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Cuenta_direccion extends S3TablaBD {

    protected $table = 'cuenta_direccion';

    public function borrarDirecciones($idCli) {
        static::query()
                ->where('cuenta_id', '=', $idCli)
                ->delete();
    }

    public function guardar($idCli, $idDir) {
        $data = array(
            "cuenta_id" => $idCli,
            "direccion_id" => $idDir,
            "eliminado" => 0
        );
        static::insert($data);
    }


}
