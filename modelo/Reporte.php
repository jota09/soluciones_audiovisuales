<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

use Illuminate\Database\Eloquent\Model as Eloquent;

class Reporte extends Eloquent {

    public function obtenerRegistros($filtros = null) {
        $listaRegistros['datos'] = $this->get_data($filtros);
        return $listaRegistros;
    }

    public function obtenerNombreArchivo() {
        return 'ContratoArriendoXComercial.xls';
    }

    public function obtenerNombreHojaPrincipal() {
        $name = $this->obtenerNombreArchivo();
        $name = str_replace('_', ' ', $name);
        $name = str_replace('.xls', '', $name);
        return $name;
    }

    public function obtenerCabeceras() {
        $cabeceras = array(
            'Cédula',
            'Nombres y Apellidos',
            'Nivel',
            'Área',
            'Puesto Genérico',
            'Cargo',
            'Sexo',
            'Necesidad de Formación',
            '¿Asistío?',
        );

        return $cabeceras;
    }

    public function get_data($filtros) {

        $lista = array(
            array(
                "anio_mes" => 'Ene. 2015',
                "meta" => 23.5,
                "presupuesto" => 18.1
            ),
            array(
                "anio_mes" => 'Feb. 2015',
                "meta" => 30.1,
                "presupuesto" => 23.9
            ),
            array(
                "anio_mes" => 'Mar. 2015',
                "meta" => 26.2,
                "presupuesto" => 22.8
            ),
            array(
                "anio_mes" => 'Feb. 2016',
                "meta" => 30.1,
                "presupuesto" => 23.9
            ),
            array(
                "anio_mes" => 'Mar. 2016',
                "meta" => 26.2,
                "presupuesto" => 22.8
            ),
            array(
                "anio_mes" => 'Feb. 2017',
                "meta" => 30.1,
                "presupuesto" => 23.9
            ),
            array(
                "anio_mes" => 'Mar. 2017',
                "meta" => 26.2,
                "presupuesto" => 22.8
            ),
        );
        return $lista;
    }

}
