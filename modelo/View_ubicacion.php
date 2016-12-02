<?php


if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class View_ubicacion extends S3TablaBD {

    protected $table = 'view_ubicacion';

    public function obtenerListaRegistros($buscarxTxt) {
        
        $listaRegistros = array();
        $bdObjeto = static::query()
                ->whereRaw("ubicacion LIKE '%" . $buscarxTxt . "%' ")
                ->take(20)
                ->get();
        
        $listaRegistros = $bdObjeto->toArray();
//        for ($i = 0; $i < count($listaRegistros); $i++){
//           if( isset($listaRegistros[$i+1]['id'])){
//           $existe = preg_match("/".$listaRegistros[$i]['id']."/i", $listaRegistros[$i+1]['id']);
//           __P($existe);
//          }
//      }
//__P($listaRegistros);
        return $listaRegistros;
    }

    public function obtenerUbicacionxIdCli($idCli) {
        die($idCli);
        $listaRegistros = array();
        $bdObjeto = static::query()
                ->whereRaw("ubicacion LIKE '%" . $buscarxTxt . "%'")
                ->get();
        $listaRegistros = $bdObjeto->toArray();

        return $listaRegistros;
    }

}
