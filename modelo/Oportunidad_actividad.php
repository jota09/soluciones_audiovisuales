<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Oportunidad_actividad extends S3TablaBD {

    protected $table = 'oportunidad_actividad';
    
    public function guardar($oportunidadId, $actividadId) {
        $data = array(
            "oportunidad_id" => $oportunidadId,
            "actividad_id" => $actividadId
        );
        static::insert($data);
    }

    public function obtenerActividadXOportunidad($oportunidadId) {
        $listaRegistros = array();

        $bdObjeto = static::query()
                ->selectRaw("actividad.*")
                ->join('actividad', 'actividad.id', '=', 'oportunidad_actividad.actividad_id')
                ->whereRaw("oportunidad_actividad.eliminado=? AND actividad.eliminado=? AND oportunidad_actividad.oportunidad_id=?", array(0, 0, $oportunidadId))
                ->get();
        $listaRegistros = $bdObjeto->toArray();

        return $listaRegistros;
    }

}
