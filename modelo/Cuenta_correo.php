<?php


if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Cuenta_correo extends S3TablaBD {

    protected $table = 'cuenta_correo';

    public function borrarCorreos($idCli) {
         static::query()
                ->where('cuenta_id', '=', $idCli)
                ->delete();
    }

    public function guardar($idCli, $idCorreo) {
         $data = array(
            "cuenta_id" => $idCli,
            "correo_id" => $idCorreo,
            "eliminado" => 0
        );
        static::insert($data);
    }



}
