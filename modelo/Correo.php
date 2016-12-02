<?php

/**
 * Clase desarrollada por
 * @author kid_goth
 * 2013 | Soluciones 360 Grados
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class Correo extends S3TablaBD {

    protected $table = 'correo';

    public function guardar($id, $modulo, $pos) {
        global $aplicacion;
        $this->cargarCampos();

        if ($modulo == "Contacto_correo") {
            require_once 'modelo/Contacto_correo.php';
            $contacto_tel = new Contacto_correo();
        } else if ($modulo == "Cliente_potencial_correo") {
            require_once 'modelo/ClientePotencial_correo.php';
            $cliente_tel = new ClientePotencial_correo();
        } else if ($modulo == "Cuenta_correo") {

            require_once 'modelo/Cuenta_correo.php';
            $cuenta_tel = new Cuenta_correo();
        }
        $request = new S3Request();
        $post = $request->obtenerVariables();

        if (!empty($post['correo_id'][$pos])) {
            $bdObjeto = static::query()
                    ->find($post['correo_id'][$pos]);
        } else {
            $bdObjeto = $this;
        }

        if (!empty($bdObjeto) && $bdObjeto->id > 0) {
            if (in_array('actualizado_por', $this->camposTabla)) {
                $bdObjeto->actualizado_por = $aplicacion->getUsuario()->getId();
            }
            if (in_array('fecha_modificacion', $this->camposTabla)) {
                $bdObjeto->fecha_modificacion = date('Y-m-d H:i:s');
            }
        } else {

            if (in_array('creado_por', $this->camposTabla)) {
                $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
            }
            if (in_array('fecha_creacion', $this->camposTabla)) {

                $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
            }
        }

        $bdObjeto->correo = $post['e_mail'][$pos];
        $bdObjeto->eliminado = $post['correo_eliminado'][$pos];
        $bdObjeto->principal = $post['correo_principal'][$pos];

        $bdObjeto->save();
        if (empty($post['correo_id'][$pos])) {
            if ($modulo == "Contacto_correo") {
                $contacto_tel->guardar($id, $bdObjeto->id);
            } else if ($modulo == "Cliente_potencial_correo") {
                $cliente_tel->guardar($id, $bdObjeto->id);
            } else if ($modulo == "Cuenta_correo") {
                require_once 'modelo/Cuenta_correo.php';
                $cuenta_tel->guardar($id, $bdObjeto->id);
            }
        }
    }

    public function guardarConvertir($id, $modulo, $pos) {
        global $aplicacion;
        $this->cargarCampos();

        if ($modulo == "Contacto_correo") {
            require_once 'modelo/Contacto_correo.php';
            $contacto_tel = new Contacto_correo();
        } else if ($modulo == "Cliente_potencial_correo") {
            require_once 'modelo/ClientePotencial_correo.php';
            $cliente_tel = new ClientePotencial_correo();
        } else if ($modulo == "Cuenta_correo") {

            require_once 'modelo/Cuenta_correo.php';
            $cuenta_tel = new Cuenta_correo();
        }
        $request = new S3Request();
        $post = $request->obtenerVariables();
        $post['correo_id'][$pos] = '';
//    __P($post);

        if (!empty($post['correo_id'][$pos])) {
            $bdObjeto = static::query()
                    ->find($post['correo_id'][$pos]);
        } else {
            $bdObjeto = $this;
        }

        if (!empty($bdObjeto) && $bdObjeto->id > 0) {
            if (in_array('actualizado_por', $this->camposTabla)) {
                $bdObjeto->actualizado_por = $aplicacion->getUsuario()->getId();
            }
            if (in_array('fecha_modificacion', $this->camposTabla)) {
                $bdObjeto->fecha_modificacion = date('Y-m-d H:i:s');
            }
        } else {

            if (in_array('creado_por', $this->camposTabla)) {
                $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
            }
            if (in_array('fecha_creacion', $this->camposTabla)) {

                $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
            }
        }

        $bdObjeto->correo = $post['e_mail'][$pos];
        $bdObjeto->eliminado = $post['correo_eliminado'][$pos];
        $bdObjeto->principal = $post['correo_principal'][$pos];
        $bdObjeto->save();

        if (empty($post['correo_id'][$pos])) {

            if ($modulo == "Contacto_correo") {
                $contacto_tel->guardar($id, $bdObjeto->id);
            } else if ($modulo == "Cliente_potencial_correo") {
                $cliente_tel->guardar($id, $bdObjeto->id);
            } else if ($modulo == "Cuenta_correo") {
                $cuenta_tel->guardar($id, $bdObjeto->id);
            }
        }
    }

    public function obtenerCorreoXModulo($moduloId, $modulo) {
        $bdObjeto = static::query()
                ->selectRaw("correo.id AS correo_id, correo as e_mail, principal")
                ->join($modulo . "_correo", $modulo . "_correo.correo_id", "=", "correo.id")
                ->whereRaw("correo.eliminado=0 AND " . $modulo . "_correo.eliminado =0 AND " . $modulo . "_correo." . $modulo . "_id = " . $moduloId)
                ->get();

        return $bdObjeto->toArray();
    }

    public function obtenerCorreoXidUsuarios($usuarios_id) {
        $bdObjeto = Usuario::query()->whereRaw("eliminado=0 AND id IN($usuarios_id)")
                ->get();

        return $bdObjeto->toArray();
    }

}
