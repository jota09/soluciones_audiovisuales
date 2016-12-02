<?php

/**
 * Clase desarrollada por
 * @author kid_goth
 * 2013 | Soluciones 360 Grados
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Ubicacion extends S3TablaBD {

    protected $table = 'ubicacion';

    public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

        $bdObjeto = static::query()
                ->selectRaw("ubicacion.id, ubicacion.nombre, u1.nombre as padre, tu.nombre as tipo, ubicacion.activo ")
                ->leftJoin('ubicacion as u1', 'u1.id', '=', 'ubicacion.ubicacion_padre_id')
                ->join('tipo_ubicacion as tu', 'tu.id', '=', 'ubicacion.tipo_ubicacion_id')
                ->whereRaw("ubicacion.activo = 1  and ubicacion.eliminado = 0 Order by ubicacion.id");
        if ($ajaxTabla) {
            $this->obtenerListaRegistrosAjaxTabla($bdObjeto);
        }

        if ($only) {
            $bdObjeto->take(1)->skip(0);
        }

        $arrayCli = $bdObjeto->get()->toArray();

        if ($ajaxTabla) {
            $this->postObtenerListaRegistrosAjaxTabla($arrayCli);
        }
//        __P($arrayCli);
        return $arrayCli;
    }

    public function guardar_($nombre, $tipo_ubicacion, $ubicacion_padre) {

        $bdObjeto = DB_DataObject::factory($this->nombreDO);


        $bdObjeto->nombre = utf8_encode($nombre);
        $bdObjeto->tipo_ubicacion_id = $tipo_ubicacion;
        $bdObjeto->ubicacion_padre_id = $ubicacion_padre;
        $bdObjeto->find();

        while ($bdObjeto->fetch()) {
            $registro = $bdObjeto->toArray();
        }
        if (empty($registro)) {
            $bdObjeto->insert();
            return $bdObjeto->id;
        }
    }

    public function obtenerxIdCliente($id_cliente) {

        die('holas');
    }

    public function obtenerListaRegistrosTabla() {
        $this->cargarCampos();
        $bdObjeto = static::query();

        $bdObjeto->selectRaw('ubicacion.*, tipo_ubicacion.nivel');
        $bdObjeto->join('tipo_ubicacion', 'tipo_ubicacion.id', '=', 'ubicacion.tipo_ubicacion_id');

        return $bdObjeto->get()->toArray();
    }

    public function obtenerPaises() {
        return $objUbicacion = static::query()->whereRaw("ubicacion_padre_id IS NULL AND eliminado=0")->get()->toArray();
    }

    protected function prelistar(&$bdObjeto) {
        parent::prelistar($bdObjeto);

        $bdObjeto->selectRaw('ubicacion.id, tipo_ubicacion.nombre AS tipo_ubicacion_id, ubicacionp.nombre AS ubicacion_padre_id, ubicacion.nombre AS nombre, ubicacion.activo AS activo')
                ->leftJoin('tipo_ubicacion', 'ubicacion.tipo_ubicacion_id', '=', 'tipo_ubicacion.id')
                ->join('ubicacion AS ubicacionp', 'ubicacionp.id', '=', 'ubicacion.ubicacion_padre_id');
    }

    protected function obtenerListaRegistrosAjaxTabla(&$bdObjeto) {
        $this->camposTabla = array(
            'tipo_ubicacion.nombre',
            'ubicacionp.nombre',
            'ubicacion.nombre'
        );


        parent::obtenerListaRegistrosAjaxTabla($bdObjeto);
    }
    
    public function segmentarUbicacion($TipoUbicacion){
        $bdObjeto = static::query()
                ->selectRaw('id, nombre ')
                ->whereRaw("eliminado = 0 and tipo_ubicacion_id = ".$TipoUbicacion);
        
        $registros = $bdObjeto->get()->toArray();
        //__P($registros);
        
        return $registros;
    }

}
