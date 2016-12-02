<?php


if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class View_categoria extends S3TablaBD {

    protected $table = 'view_categoria';

    public function obtenerListaRegistros() {
        
        $listaRegistros = array();
        $bdObjeto = static::query()
               // ->whereRaw("categoria LIKE '%" . $buscarxTxt . "%' ")
                //->take(20)
                ->get();

        $listaRegistros = $bdObjeto->toArray();

        return $listaRegistros;
    }

    public function obtenerCategoriaxId($idCli) {
        die($idCli);
        $listaRegistros = array();
        $bdObjeto = static::query()
                ->whereRaw("categoria LIKE '%" . $buscarxTxt . "%'")
                ->get();
        $listaRegistros = $bdObjeto->toArray();

        return $listaRegistros;
    }

}
