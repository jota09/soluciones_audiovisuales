<?php


if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Contacto_correo extends S3TablaBD {

    protected $table = 'contacto_correo';

    public function borrarCorreos($idCli) {
         static::query()
                ->where('contacto_id', '=', $idCli)
                ->delete();
    }

    public function guardar($idCli, $idCorreo) {
         $data = array(
            "contacto_id" => $idCli,
            "correo_id" => $idCorreo,
            "eliminado" => 0
        );
        static::insert($data);
    }

    public function obtenerCorreoxIdCli($idCli) {
        $listaRegistros = array();
        
        $bdObjeto = static::query()
                ->selectRaw("correo.id AS correo_id,correo.e_mail,correo.principal")
                ->join('correo', 'correo.id', '=', 'contacto_correo.correo_id')
                ->whereRaw("contacto_correo.eliminado=? AND correo.eliminado=? AND contacto_correo.contacto_id=?", array(0, 0, $idCli))
                ->get();
        $listaRegistros = $bdObjeto->toArray();

        return $listaRegistros;
    }

}
