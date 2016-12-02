<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class AccionesCiudades extends S3Accion {

    public function accionCargaDepartamentos() {
        die('accionCargaDepartamentos');
//        require_once 'modelo/negocio/objetos/Ubicacion.php';
//        $archivo = getcwd() . "/modulos/ciudades/ListadoDeptosCiudades_2014.csv";
        $archivo = getcwd() . "/modulos/ciudades/ListadoLocalidadUPZ_2014.csv";
        if (file_exists($archivo)) {

            if (($gestor = fopen($archivo, "r")) !== FALSE) {
                while (($datos = fgetcsv($gestor)) !== FALSE) {

                    $datos[0] = sanear_string(utf8_decode($datos[0]));
                    $datos[1] = utf8_decode($datos[1]);

                    if ($datos[0] != null || $datos[0] != '') {
                        $lista[$datos[0]][] = ucfirst(mb_strtolower($datos[1]));
                    }
                }
                // ListadoDeptosCiudades_2014
//                foreach ($lista as $departamento => $depto) {
//
//                    $objUbicacion = new Ubicacion();
//                    $id = $objUbicacion->guardar($departamento, 2, 1);
//
//                    foreach ($depto as $ciudad) {
//                        $objUbicacion2 = new Ubicacion();
//                        $objUbicacion2->guardar($ciudad, 3, $id);
//                    }
//                }
                //ListadoLocalidadUPZ_2014.csv
//                foreach ($lista as $localidades => $localidad) {
//
//                    $objUbicacion = new Ubicacion();
//                    $id = $objUbicacion->guardar($localidades, 4, 314);
//
//                    foreach ($localidad as $upz) {
//
//                        $objUbicacion2 = new Ubicacion();
//                        $objUbicacion2->guardar($upz, 5, $id);
//                    }
//                }
                die('Acabe');
            }
        } else {
            die('NO EXIXSTE: ' . $archivo);
        }
    }

}
