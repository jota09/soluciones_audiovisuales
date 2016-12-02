<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Contacto_telefono extends S3TablaBD {

    protected $table = 'contacto_telefono';

    public function borrarTelefonos($idCli) {
        static::query()
                ->where('contacto_id', '=', $idCli)
                ->delete();
    }

    public function guardar($idCli, $idTel) {
        $data = array(
            "contacto_id" => $idCli,
            "telefono_id" => $idTel,
            "eliminado" => 0
        );
        static::insert($data);
    }

    public function obtenerTelxIdCli($idCli) {

        $bdObjeto = static::query()
                ->selectRaw('telefono.id AS telefono_id,telefono.num,telefono.tipo')
                ->join('telefono', 'telefono.id', '=', 'contacto_telefono.telefono_id')
                ->whereRaw('(telefono.eliminado = ? AND contacto_telefono.contacto_id=?)', array(0, $idCli))
                ->get();
        return $bdObjeto->toArray();
    }

}
