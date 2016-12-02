<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

//require_once('base/app/reportes/S3ReporteExportable.php');

class VentasxComercial {

    public function obtenerRegistros($filtros = null) {
        $listaRegistros['datos'] = $this->get_data($filtros);
        return $listaRegistros;
    }

    public function obtenerNombreArchivo() {
        return 'Cumplimiento_Metas.xls';
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
                "comercial" => 'Comercial 1',
                "ventas" => 23.5,
            ),
            array(
                "comercial" => 'Comercial 2',
                "ventas" => 30.1,
            ),
            array(
                "comercial" => 'Comercial 3',
                "ventas" => 26.2,
            ),
            array(
                "comercial" => 'Comercial 4',
                "ventas" => 30.1,
            ),
            array(
                "comercial" => 'Comercial 5',                
                "ventas" => 22.8
            ),
            array(
                "comercial" => 'Comercial 6',
                "ventas" => 26.2,
            ),
            array(
                "comercial" => 'Comercial 7',
                "ventas" => 30.1,
            ),
            array(
                "comercial" => 'Comercial 8',                
                "ventas" => 27.8
            ),
        );
        return $lista;
    }

}
