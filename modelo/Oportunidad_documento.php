<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Oportunidad_documento extends S3TablaBD {

    protected $table = 'oportunidad_documento';
    
    public function guardar($oportunidadId, $documentoId) {
        $data = array(
            "oportunidad_id" => $oportunidadId,
            "documento_id" => $documentoId
        );
        static::insert($data);
    }

    public function obtenerActividadXOportunidad($oportunidadId) {
        $listaRegistros = array();

        $bdObjeto = static::query()
                ->selectRaw("documento.*")
                ->join('documento', 'documento.id', '=', 'oportunidad_documento.documento_id')
                ->whereRaw("oportunidad_documento.eliminado=? AND documento.eliminado=? AND oportunidad_documento.oportunidad_id=?", array(0, 0, $oportunidadId))
                ->get();
        $listaRegistros = $bdObjeto->toArray();

        return $listaRegistros;
    }

}
