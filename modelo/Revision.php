<?php

if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Revision extends S3TablaBD {

    protected $table = 'revision';

    public function ObtenerRevisionesxDocumento($id_documento) {
        $objeto = static::query()
                ->selectRaw('revision.*, usuario.nombre_usuario')
                ->join('usuario', 'usuario.id', '=', 'revision.creado_por')
                ->whereRaw('revision.documentos_id=? and revision.eliminado=?', array($id_documento, '0'))
                ->orderBy('revision.id', 'DESC')
                //    ->get()->first();
                ->get();
        $lista = $objeto->toArray();


//        $bdObjeto = static::query()
//                ->selectRaw('telefono.id AS telefono_id,telefono.num,telefono.tipo')
//                ->join('telefono', 'telefono.id', '=', 'captacion_telefono.telefono_id')
//                ->whereRaw('(telefono.eliminado = ? AND captacion_telefono.captacion_id=?)', array(0, $idCli))
//                ->get();
        // __P($lista);


        return $lista;
    }

    public function crear_revision($user) {

//__P($_POST);
        //   $nombre = $_POST['nombre'] . '_';

        $fecha = date('Y-m-d');
        if ($_FILES["file"]["name"] != '') {
            $bdObjeto = static::query()
                    ->where('documentos_id', '=', $_POST['id_doc'])
                    ->update(array('bandera' => 0));
            $test = Revision::insertGetId(array(
                        'bandera' => '1',
                        'documentos_id' => $_POST['id_doc'],
                        'nombre' => $_POST['nombre'],
                        // 'adjunto' => $adjunto,
                        'version' => $_POST['revision'],
                        'creado_por' => $user,
                        'fecha_creacion' => $fecha,
                        'descripcion' => $_POST['descripcion'],
            ));


//            $nombre = $_POST['nombre'] . '_' . $_POST['id_doc'] . '_' . $test;
//            $nombre = $nombre . '.' . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
//            $_FILES["file"]["name"] = $nombre;


            $nombre_adjunto = $_FILES["file"]["name"];
            $nombre = $test;
            $_FILES["file"]["name"] = $nombre . '_' . $_FILES["file"]["name"];
            $adjuntos = new S3Upload('adjuntos/');
            $adjuntos->setExtension(array('pdf', 'xls', 'xlsx', 'doc', 'docx', 'txt'));
            $x = $adjuntos->subirArchivo('file', false);

            $stri = $x['success']['url'];
            $n = explode("/", $stri);
            $adjunto = $n[2];

            $bdObjeto = static::query()
                    ->where('id', '=', $test)
                    ->update(array('adjunto' => $adjunto, 'nombre_adjunto' => $nombre_adjunto)
            );
            require_once 'modelo/Documentos.php';
            $documentos = new Documentos();
            $documentos->actualizar_documento($_POST['id_doc'], $_POST['revision'], $adjunto,$nombre_adjunto);
        }

        $array = array();

        $array[] = $nombre_adjunto;
        $array[] = $adjunto;
        $array[] = $_POST['revision'];
        die(json_encode($array));
    }

    public function quitar_revisionesxdocumento($id_documento) {
        $bdObjeto = static::query()
                ->where('documentos_id', '=', $id_documento)
                ->update(array('eliminado' => 1)
        );
    }

}
