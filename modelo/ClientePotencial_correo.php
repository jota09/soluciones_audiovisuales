<?php


if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class ClientePotencial_correo extends S3TablaBD {

    protected $table = 'cliente_potencial_correo';

    public function borrarCorreos($idCli) {
         static::query()
                ->where('cliente_potencial_id', '=', $idCli)
                ->delete();
    }

    public function guardar($idCli, $idCorreo, $principal) {
         $data = array(
            "cliente_potencial_id" => $idCli,
            "correo_id" => $idCorreo,
            "eliminado" => 0
        );
        static::insert($data);
    }



}
