<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Fotos extends S3TablaBD {

    protected $table = 'foto';

    public function crear_foto() {

        $request = new S3Request();
        $post = $request->obtenerVariables();
        foreach ($post['nombre_foto'] as $k => $v) {

            $id = Fotos::insertGetId(array(
                        'nombre' => $post['nombre_foto'][$k],
                        'descripcion' => $post['descripcion_foto'][$k],
                        'bandera' => $post['check'][$k],
                        'gestion_inmueble_id' => $post['registro_id'],
            ));
            if ($post['check'][$k] == '1') {
                $this->set_foto_principal($id, $post['registro_id']);
            }
            $carpeta = 'img_gestion';
            global $aplicacion;
            $dir_uploads = $aplicacion->getConfig()->getVariableConfig('aplicacion-upload-directorio');
            $carpeta = $dir_uploads . $carpeta;
            $destino = substr($carpeta, -1, 1) != '/' ? $carpeta . '/' : $carpeta;
            $ruta_destino = $destino . $id;
            $path = $_FILES['file']['name'][$k];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $path = $ruta_destino . '.' . $ext;

            if (!move_uploaded_file($_FILES["file"]['tmp_name'][$k], $path)) {
                $this->actualizar_foto($id, '1', '0');
                die('error al cargar imagen: revise permisos en el directorio o la exstencia de la carpeta -> ' . $carpeta);
            } else {
//                $path= $ruta_destino . '.' . $ext;

                $this->actualizar_foto($id, '0', $path);
            }
        }

        die(json_encode('1'));
    }

    public function actualizar_foto($id_foto, $eliminado, $path) {

        $objMeta = static::query()
                ->find($id_foto);
        $objMeta->path = $path;
        $objMeta->eliminado = $eliminado;
        $objMeta->update();
    }

    public function set_foto_principal($id_foto, $id_gestion) {

        $objFoto = static::query()
                ->where('id', '!=', $id_foto)
                ->where('gestion_inmueble_id', '=', $id_gestion)
                ->update(array('bandera' => 0)
        );
    }

    public function set_foto_principal_ajax($id_foto, $id_gestion) {

        $objFoto = static::query()
                ->where('id', '!=', $id_foto)
                ->where('gestion_inmueble_id', '=', $id_gestion)
                ->update(array('bandera' => 0)
        );

        $this->set_principal($id_foto);

        die(json_encode('1'));
    }

    public function set_principal($id_foto) {
        $objFoto = static::query()
                ->where('id', '=', $id_foto)
                ->update(array('bandera' => 1)
        );
    }

    public function obtenerFotos($id_gestion, $orderPrincipal = FALSE) {
        $orderBy = '';
        if ($orderPrincipal) {
            $orderBy = ' ORDER BY bandera DESC';
        }


        return static::query()
                        ->where('gestion_inmueble_id', '=', $id_gestion)
                        ->whereRaw('eliminado=0 ' . $orderBy)
                        ->get()
                        ->toArray();
    }

    public function eliminar_foto($id) {
        $objFoto = static::query()
                ->where('id', '=', $id)
                ->update(array('eliminado' => 1)
        );
        die(json_encode('1'));
    }

    public function editar_foto($id, $nombre, $descripcion) {
        $objFoto = static::query()
                ->where('id', '=', $id)
                ->update(array(
            'nombre' => $nombre,
            'descripcion' => $descripcion
                )
        );
        die(json_encode('1'));
    }

}
