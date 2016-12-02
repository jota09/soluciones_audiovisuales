<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Contacto_documento extends S3TablaBD {

    protected $table = 'contacto_documento';

    public function borrarDirecciones($idCli) {
        static::query()
                ->where('contacto_id', '=', $idCli)
                ->delete();
    }

    public function guardar($idCli, $idDir) {
        $data = array(
            "contacto_id" => $idCli,
            "documento_id" => $idDir,
            "eliminado" => 0
        );
        static::insert($data);
    }

    public function obtenerDirxIdCli($idCli) {

        $listaRegistros = array();
        $bdObjeto = static::query()
                ->selectRaw("d.id AS direccion_id,d.direccion,d.tipo,d.barrio")
                ->join('direccion AS d', 'd.id', '=', 'contacto_direccion.direccion_id')
                ->whereRaw("contacto_direccion.eliminado=? AND d.eliminado=? AND contacto_direccion.contacto_id=?", array(0, 0, $idCli))
                ->get();
        $listaRegistros = $bdObjeto->toArray();

        return $listaRegistros;
    }

}
