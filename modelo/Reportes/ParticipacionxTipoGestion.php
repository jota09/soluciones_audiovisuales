<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

//require_once('base/app/reportes/S3ReporteExportable.php');

class ParticipacionxTipoGestion {

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
                "tipo_gestion" => 'Tipo1',
                "porcentaje" => 23.5,
            ),
            array(
                "tipo_gestion" => 'Tipo2',
                "porcentaje" => 30.1,
            ),
            array(
                "tipo_gestion" => 'Tipo3',
                "porcentaje" => 26.2,
            ),
            array(
                "tipo_gestion" => 'Tipo4',
                "porcentaje" => 30.1,
            ),
            array(
                "tipo_gestion" => 'Tipo5',                
                "porcentaje" => 22.8
            ),
            array(
                "tipo_gestion" => 'Tipo3',
                "porcentaje" => 26.2,
            ),
            array(
                "tipo_gestion" => 'Tipo4',
                "porcentaje" => 30.1,
            ),
            array(
                "tipo_gestion" => 'Tipo5',                
                "porcentaje" => 22.8
            ),
        );
        return $lista;
    }

}
