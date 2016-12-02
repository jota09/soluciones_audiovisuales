<?php
 
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}
 
class Actividades extends S3TablaBD {
 
    protected $table = 'actividad';
 
    public function preguardar(&$bdObjeto) {
        parent::preguardar($bdObjeto);
        $post = new S3Request();
        $post = $post->obtenerVariables();
        $post = $this->formatearPost($post);
 
        $bdObjeto->fecha_inicio = $post['fecha_inicio'];
        $bdObjeto->fecha_fin = $post['fecha_fin'];
        $bdObjeto->hora_inicio = $post['fecha_inicio_hora_actividad'] . ':' . $post['fecha_inicio_minutos'] . ':00';
        $bdObjeto->hora_fin = $post['fecha_fin_hora_actividad'] . ':' . $post['fecha_fin_minutos'] . ':00';
        $bdObjeto->meridiano_inicio = $post['fecha_inicio_am'];
        $bdObjeto->meridiano_fin = $post['fecha_fin_am'];
//      __P($post);
    }
    
    public function obtenerListaRegistros2($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {
        $this->cargarCampos();
        $bdObjeto = static::query();

        //$this->prelistar($bdObjeto);

        foreach ($where AS $w) {
            if (in_array($w['columna'], $this->camposTabla)) {
                $bdObjeto->where($this->table . '.' . $w['columna'], $w['condicional'], $w['valor']);
                //__P($this->table . '.' . $w['columna'].','.$w['condicional'].', '.$w['valor'], false);
            }
        }

        if ($ajaxTabla) {
            $this->obtenerListaRegistrosAjaxTabla($bdObjeto);
        }

        if ($only) {
            $bdObjeto->take(1)->skip(0);
        }

        $rtnListaRegistros = $bdObjeto->orderBy($this->table . '.id', 'DESC')->get()->toArray();

        if ($ajaxTabla) {
            $this->postObtenerListaRegistrosAjaxTabla($rtnListaRegistros);
        }
        //__P($bdObjeto->toSql(), false);
        return $rtnListaRegistros;
    }
 
    public function guardar(&$bdObjeto) {
        global $aplicacion;
        $this->cargarCampos();
 
        $request = new S3Request();
        $registroId = $request->obtenerVariablePGR('registro_id');
        $variablesPost = $request->obtenerVariables();
 
 
        if (!empty($registroId)) {
            $bdObjeto = static::query()
                    ->find($registroId);
        } else {
            $bdObjeto = $this;
        }
 
        foreach ($variablesPost as $variablePost => $valorPost) {
            if (in_array($variablePost, $this->camposTabla)) {
                $bdObjeto->$variablePost = (empty($valorPost)) ? NULL : $valorPost;
            }
        }
 
        if (!empty($bdObjeto) && $bdObjeto->id > 0) {
            if (in_array('actualizado_por', $this->camposTabla)) {
                $bdObjeto->actualizado_por = $aplicacion->getUsuario()->getId();
            }
            if (in_array('fecha_modificacion', $this->camposTabla)) {
                $bdObjeto->fecha_modificacion = date('Y-m-d H:i:s');
            }
 
            $this->preguardar($bdObjeto);
            $bdObjeto->save();
            $this->postguardar($bdObjeto);
        } else {
            if (in_array('creado_por', $this->camposTabla)) {
                $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
            }
            if (in_array('fecha_creacion', $this->camposTabla)) {
                $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
            }
            $bdObjeto->usuario_id = $aplicacion->getUsuario()->getId();
 
            $this->preguardar($bdObjeto);
            $bdObjeto->save();
            $this->postguardar($bdObjeto);
        }
 
        return $bdObjeto;
    }
 
    public function obtenerRegistro($registro) {
        $reg = parent::obtenerRegistro($registro);
        $reg = $this->desFormatear($reg);
        return $reg;
    }
 
    public function guardarAjax($actulizar) {
        global $aplicacion;
        $request = new S3Request();
        $post = $request->obtenerVariables();
 
        if (!$actulizar) {
            $post = $this->formatearPost($post);
        }
 
        $nuevo = false;
        if ($post['id'] > 0) {
            $objActividad = static::query()
                    ->find($post['id']);
        } else {
            $nuevo = true;
            $objActividad = $this;
        }
 
        $objActividad->nombre = $post['nombre'];
        $listaFI = explode(" ", $post['fecha_inicio']);
        $objActividad->fecha_inicio = $listaFI[0];
        $objActividad->hora_inicio = $listaFI[1];
        $objActividad->meridiano_inicio = $post['fecha_inicio_am'];
        $listaFF = explode(" ", $post['fecha_fin']);
        $objActividad->fecha_fin = $listaFF[0];
        $objActividad->hora_fin = $listaFF[1];
        $objActividad->meridiano_fin = $post['fecha_fin_am'];
        $objActividad->usuario_id = $aplicacion->getUsuario()->getId();
 
        $objActividad->tipo = $post['tipo'];
        $objActividad->relacionado = $post['relacionado'];
        $objActividad->relacionado_id = $post['relacionado_id'];
        $objActividad->estado = $post['estado'];
        $objActividad->aviso = $post['aviso'];
        $objActividad->prioridad = $post['prioridad'];
        $objActividad->contacto = $post['contacto'];
 
        $objActividad->duracion = $post['duracion'];
        $objActividad->tipo_llamada = $post['tipo_llamada'];
        $objActividad->lugar = $post['lugar'];
        $objActividad->fecha_creacion = date('Y-m-d H:i:s');
        $objActividad->creado_por = $aplicacion->getUsuario()->getId();
 
        $objActividad->save();
 
        /* GUARDAR RELACION CON MODULOS */
        $this->guardarRelaciones($post, $objActividad->id);
 
 
        $lista = array(
            'id' => $objActividad->id,
            'nombre' => $objActividad->nombre,
            'fecha_inicio' => $objActividad->fecha_inicio,
            'fecha_fin' => $objActividad->fecha_fin,
            'nuevo' => $nuevo,
        );
        die(json_encode($lista));
    }
 
    private function guardarRelaciones($post, $objActividad) {
 
        if ($post['relacionado'] == 12) { // CUENTA
            require_once 'modelo/Cuenta_actividad.php';
            $cuenta_act = new Cuenta_actividad();
            $cuenta_act->guardar($post['relacionado_id'], $objActividad);
        }
        if ($post['relacionado'] == 5) { // Oportunidad
            require_once 'modelo/Oportunidad_actividad.php';
            $oportunidada_act = new Oportunidad_actividad();
            $oportunidada_act->guardar($post['relacionado_id'], $objActividad);
        }
        if ($post['relacionado'] == 22) { // Contacto
            require_once 'modelo/Contacto_actividad.php';
            $contacto_act = new Contacto_actividad();
            $contacto_act->guardar($post['relacionado_id'], $objActividad);
        }
        if ($post['relacionado'] == 25) { // ACUERDO
            require_once 'modelo/Acuerdo_actividad.php';
            $acuerdo_act = new Acuerdo_actividad();
            $acuerdo_act->guardar($post['relacionado_id'], $objActividad);
        }
        if ($post['relacionado'] == 30) { // SERVICIO
            require_once 'modelo/Servicio_actividad.php';
            $acuerdo_act = new Servicio_actividad();
            $acuerdo_act->guardar($post['relacionado_id'], $objActividad);
        }
        if ($post['relacionado'] == 29) { // ACUERDO
            require_once 'modelo/Convenio_actividad.php';
            $acuerdo_act = new Convenio_actividad();
            $acuerdo_act->guardar($post['relacionado_id'], $objActividad);
        }
        if ($post['relacionado'] == 14) { // CASOS
            require_once 'modelo/Caso_actividad.php';
            $caso_act = new Caso_actividad();
            $caso_act->guardar($post['relacionado_id'], $objActividad);
        }
        if ($post['relacionado'] == 7) { // Cliente POtencial
            require_once 'modelo/ClientePotencial_actividad.php';
            $cliente_act = new ClientePotencial_actividad();
            $cliente_act->guardar($post['relacionado_id'], $objActividad);
        }
 
        require_once 'modelo/Invitados.php';
        $invitados = new Invitados();
        $invitados->guardar($objActividad);
    }
 
    protected function formatearPost($post) {
        $tiempoInicio = $this->formaterTiempo($post['fecha_inicio_hora'] . ':' . $post['fecha_inicio_minutos'] . $post['fecha_inicio_am']);
        $tiempoFin = $this->formaterTiempo($post['fecha_fin_hora'] . ':' . $post['fecha_fin_minutos'] . $post['fecha_fin_am']);
        $post['fecha_inicio'] = $post['fecha_inicio'] . ' ' . $tiempoInicio;
        $post['fecha_fin'] = $post['fecha_fin'] . ' ' . $tiempoFin;
        if ($post['fecha_inicio_am_actividad'] == 'PM' && $post['fecha_inicio_hora_actividad']!=12) {
            $post['fecha_inicio_hora_actividad'] += 12;
        }
        if ($post['fecha_fin_am_actividad'] == 'PM' && $post['fecha_fin_hora_actividad']!=12) {
            $post['fecha_fin_hora_actividad'] += 12;
        }
//        __P($post);
 
        $fecha1 = str_replace('-', '/', $post['fecha_inicio_actividad']) . ' ' . $post['fecha_inicio_hora_actividad'] . ':' . $post['fecha_inicio_minutos_actividad'];
        $fecha2 = str_replace('-', '/', $post['fecha_fin_actividad']) . ' ' . $post['fecha_fin_hora_actividad'] . ':' . $post['fecha_fin_minutos_actividad'];
        $post['duracion_actividad'] = obtenerMinutosEntreFechas($fecha1, $fecha2);
//__P($post);
 
        return $post;
    }
 
    public function desFormatear(&$lista) {
        $fecha_inicio_hora = strtotime($lista['hora_inicio']);
        $fecha_inicio_hora = explode(':', date('h:i:A', $fecha_inicio_hora));
        $lista['fecha_inicio_hora'] = $fecha_inicio_hora[0];
        $lista['fecha_inicio_minutos'] = $fecha_inicio_hora[1];
        $lista['fecha_inicio_am'] = $fecha_inicio_hora[2];
        $fecha_inicio = explode(' ', $lista['fecha_inicio']);
        $lista['fecha_inicio'] = $fecha_inicio[0];
 
        $fecha_fin_hora = strtotime($lista['hora_fin']);
        $fecha_fin_hora = explode(':', date('h:i:A', $fecha_fin_hora));
        $lista['fecha_fin_hora'] = $fecha_fin_hora[0];
        $lista['fecha_fin_minutos'] = $fecha_fin_hora[1];
        $lista['fecha_fin_am'] = $fecha_fin_hora[2];
        $fecha_fin = explode(' ', $lista['fecha_fin']);
        $lista['fecha_fin'] = $fecha_fin[0];
        return $lista;
    }
 
    protected function formaterTiempo($tiempo) {
        $tiempo = strtotime($tiempo);
        return date("H:i:s", $tiempo);
    }
 
    public function alertaCalendario() {
 
        global $aplicacion;
        $listaRegistros = array();
 
        $bdObjeto = static::query()
                ->selectRaw("actividad.*")
                ->whereRaw("eliminado = 0 and activo = 1 and usuario_id = " . $aplicacion->getUsuario()->getId() . " and concat_ws(' ',fecha_inicio, hora_inicio) = DATE_ADD('" . date('Y-m-d H:i:') . "00',INTERVAL 15 MINUTE)")
                ->get();
 
        $listaRegistros = $bdObjeto->toArray();
 
        if (!empty($listaRegistros)) {
            $mailer = new S3Mailer();
            $datos = array(
                'servidor' => 'http://' . $_SERVER["SERVER_NAME"] . dirname($_SERVER["SCRIPT_NAME"]),
                'nombre' => $listaRegistros[0]['nombre'],
                'inicia' => $listaRegistros[0]['fecha_inicio'] . ' ' . $listaRegistros[0]['hora_inicio'] . ' ' . $listaRegistros[0]['meridiano_inicio'],
                'finaliza' => $listaRegistros[0]['fecha_fin'] . ' ' . $listaRegistros[0]['hora_fin'] . ' ' . $listaRegistros[0]['meridiano_fin'],
                'nombreUsuario' => ucwords(strtolower($aplicacion->getUsuario()->getNombre())) . ' ' . ucwords(strtolower($aplicacion->getUsuario()->getApellido())),
            );
 
            $mailer->asignarTplBase('correo');
            $mailer->asignarPlantilla('modulos/usuarios/correo_alerta');
            $mailer->asignarDatos($datos);
 
            $mailer->enviarCorreo($aplicacion->getUsuario()->getCorreo(), 'Nice Inmobiliaria - Notificación Actividad por Vencer');
        }
 
 
        return $listaRegistros;
    }
 
    public function obtener_registros_modulo_relacionado($modulo_id, $tabla, $campos) {
        $count = count($campos[0]);
        if ($count < 2) {
            $field = $campos[0][0];
        }
        if ($count > 1) {
            $field = ' concat(' . $campos[0][0] . ', ' . $campos[0][1] . ') '; //CONCAT(Nombre, ' ', Apellidos) As Nombre
        }
        $lista = array();
        $bdObjeto = static::hydrateRaw(' select ' . $field . ' as nombre_general, id from ' . $tabla . '
                        where eliminado="0" and activo ="1" ');
        $lista = $bdObjeto->toArray();
//            
        for ($i = 0; $i < count($lista); $i++) {
            $lista[$i]['modulo_id'] = $modulo_id;
        }
 
        return $lista;
    }
 
    public function postguardar(&$bdObjeto) {
//__P($bdObjeto);
 
        require_once 'modelo/Invitados.php';
        $invitados = new Invitados();
        $invitados->guardar($bdObjeto);
 
 
 
        parent::postguardar($bdObjeto);
    }
 
    /**
     * Guarda desde el popup de relaciones Analiticas
     * @global type $aplicacion
     */
    public function guardarActividad() {
 
        $post = new S3Request();
        $post = $post->obtenerVariables();
        $post = $this->formatearPost($post);
        global $aplicacion;
        $id_usuario = $aplicacion->getUsuario()->getId();
 
        $h1 = $post['fecha_inicio_hora_actividad'] . ':' . $post['fecha_inicio_minutos_actividad'] . ':00';
        $h2 = $post['fecha_fin_hora_actividad'] . ':' . $post['fecha_fin_minutos_actividad'] . ':00';
         
//__P($h2); 
        $id = Actividades::insertGetId(array(
                    'nombre' => $_POST['referencia_actividad'],
                    'fecha_inicio' => $_POST['fecha_inicio_actividad'],
                    'hora_inicio' => $h1,
                    'meridiano_inicio' => $_POST['fecha_inicio_am_actividad'],
                    'fecha_fin' => $_POST['fecha_fin_actividad'],
                    'hora_fin' => $h2,
                    'meridiano_fin' => $_POST['fecha_fin_am_actividad'],
                    'usuario_id' => $id_usuario,
                    'tipo' => $_POST['tipo_actividad'],
                    'relacionado' => $_POST['relacionado_acti_vidad'],
                    'relacionado_id' => $_POST['relacionado_id_actividad'],
                    'estado' => $_POST['estado_actividad'],
                    'descripcion' => $_POST['descripcion_actividad'],
                    'contacto' => $_POST['cliente_actividad'],
                    'prioridad' => $_POST['prioridad_actividad'],
                    'duracion' => $post['duracion_actividad'],
                    'tipo_llamada' => $_POST['tipo_llamada_actividad'],
                    'lugar' => $_POST['lugar_actividad'],
                    'aviso' => $_POST['aviso_actividad'],
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'creado_por' => $id_usuario,
        ));
 
        /* GUARDAR RELACION CON MODULOS */
        $_POST['relacionado'] = $_POST['relacionado_acti_vidad'];
        $_POST['relacionado_id'] = $_POST['relacionado_id_actividad'];
        $this->guardarRelaciones($_POST, $id);
 
        die(json_encode('1'));
    }
 
    public function obtener_actividadesxmodulo($parametros) {
 
        if ($parametros['modulo_name'] == 'cuentas') {
            $mdl = "cuenta";
        } else if ($parametros['modulo_name'] == 'acuerdos') {
            $mdl = "acuerdo";
        } else if ($parametros['modulo_name'] == 'casos') {
            $mdl = "caso";
        } else if ($parametros['modulo_name'] == 'clientes_potenciales') {
            $mdl = "cliente_potencial";
        } else if ($parametros['modulo_name'] == 'contactos') {
            $mdl = "contacto";
        } else if ($parametros['modulo_name'] == 'oportunidades') {
            $mdl = "oportunidad";
        } else if ($parametros['modulo_name'] == 'servicios') {
            $mdl = "servicio";
        } else if ($parametros['modulo_name'] == 'convenios') {
            $mdl = "convenio";
        }
 
        $bdObjeto = static::query()
                ->selectRaw("actividad.*")
                ->join($mdl . "_actividad as ca", "ca.actividad_id", "=", "actividad.id")
                ->whereRaw('ca.' . $mdl . '_id = ' . $parametros['modulo_id'])
                ->where('ca.eliminado', '=', '0')
                ->where('actividad.eliminado', '=', '0')
                ->orderBy('actividad.id', 'DESC')
                ->get();
 
        $lista = $bdObjeto->toArray();
 
        $array = array();
        $array['tarea'] = array();
        $array['llamada'] = array();
        $array['reunion'] = array();
 
        $tarea = array();
        $llamada = array();
        $reunion = array();
        $tmp = array();
        //preformatear lista a mostrar
        for ($i = 0; $i < count($lista); $i++) {
 
            $tmp[$i]['id'] = $lista[$i]['id'];
            $tmp[$i]['nombre'] = $lista[$i]['nombre'];
            $tmp[$i]['fecha_inicio'] = $lista[$i]['fecha_inicio'];
            $tmp[$i]['hora_inicio'] = $lista[$i]['hora_inicio'];
            $tmp[$i]['meridiano_inicio'] = $lista[$i]['meridiano_inicio'];
            $tmp[$i]['fecha_fin'] = $lista[$i]['fecha_fin'];
            $tmp[$i]['hora_fin'] = $lista[$i]['hora_fin'];
            $tmp[$i]['meridiano_fin'] = $lista[$i]['meridiano_fin'];
            $tmp[$i]['tipo'] = $lista[$i]['tipo'];
            $tmp[$i]['eliminado'] = '<i class=" fa fa-minus"></i>';
        }
 
        for ($j = 0; $j < count($tmp); $j++) {
            if ($tmp[$j]['tipo'] == 38) {
                $tmp[$j]['tipo'] = 'Tarea';
                $tarea[] = $tmp[$j];
            }
            if ($tmp[$j]['tipo'] == 39) {
                $tmp[$j]['tipo'] = 'Llamada';
                $llamada[] = $tmp[$j];
            }
            if ($tmp[$j]['tipo'] == 40) {
 
                $tmp[$j]['tipo'] = 'Reunion';
                $reunion[] = $tmp[$j];
            }
        }
 
 
        $array['tarea'] = $tarea;
        $array['llamada'] = $llamada;
        $array['reunion'] = $reunion;
 
        $array['cnt_tarea'] = count($array['tarea']);
        $array['cnt_llamada'] = count($array['llamada']);
        $array['cnt_reunion'] = count($array['reunion']);
 
 
        $array['campos'] = array(
            '0' => Array
                (
                'data' => 'id',
                'mData' => 'id',
            ),
            '1' => Array
                (
                'data' => 'nombre',
                'mData' => 'nombre',
            ),
            '2' => Array
                (
                'data' => 'fecha_inicio',
                'mData' => 'fecha_inicio',
            ),
            '3' => Array
                (
                'data' => 'hora_inicio',
                'mData' => 'hora_inicio',
            ),
            '4' => Array
                (
                'data' => 'meridiano_inicio',
                'mData' => 'meridiano_inicio',
            ),
            '5' => Array
                (
                'data' => 'fecha_fin',
                'mData' => 'fecha_fin',
            ),
            '6' => Array
                (
                'data' => 'hora_fin',
                'mData' => 'hora_fin',
            ),
            '7' => Array
                (
                'data' => 'meridiano_fin',
                'mData' => 'meridiano_fin',
            ),
            '8' => Array
                (
                'data' => 'tipo',
                'mData' => 'tipo',
            ),
            '9' => Array
                (
                'data' => 'eliminado',
                'mData' => 'eliminado',
            ),
        );
//      __P($array);
        die(json_encode($array));
    }
 
    public function eliminar_actividad_por_id($id) {
 
        $objInvitado = static::query()
                ->find($id);
        $objInvitado->eliminado = 1;
        $objInvitado->update();
    }
 
    public function obtener_registrosxrelacionado($tabla, $seleccionar) {
 
        $lista = array();
        $bdObjeto = static::hydrateRaw(' select ' . $seleccionar . ' from ' . $tabla . '
                        where eliminado="0" and activo ="1" ');
        $lista = $bdObjeto->toArray();
 
        die(json_encode($lista));
    }
 
    public function misActividadesPendientes() {
        global $aplicacion;
        return static::query()
                        ->selectRaw("actividad.*,tipo_rel.nombre AS tipo_nombre,(
                                        CASE
                                            WHEN DATEDIFF(fecha_fin,DATE(NOW())) < 0 THEN 'alert-danger'
                                            WHEN DATEDIFF(fecha_fin,DATE(NOW())) <= 2 && DATEDIFF(fecha_fin,DATE(NOW())) >= 0 THEN 'alert-warning'
 
                                        END) AS alerta")
                        ->join('opcion_lista_maestra as tipo_rel', 'tipo_rel.id', '=', 'actividad.tipo')
                        ->where('actividad.usuario_id', '=', $aplicacion->getUsuario()->getID())
                        ->where('actividad.eliminado', '=', 0)
                        ->orderBy('actividad.id', 'DESC')
                        ->get()->toArray();
    }
 
    public function obtenerActividadesXrelacionId($id) {
        require_once 'modelo/Documentos.php';
        $objDocumentos = new Documentos();
        $obj = static::query()
                        ->selectRaw('actividad.*,tipo_actividad.nombre AS tipo_nombre')
                        ->leftjoin('opcion_lista_maestra as tipo_actividad', 'tipo_actividad.id', '=', 'actividad.tipo')
                        ->where('actividad.relacionado_id', '=', $id)
                        ->where('actividad.eliminado', '=', 0)
                        ->where('actividad.activo', '=', 1)
                        ->orderBy('actividad.id', 'DESC')
                        ->get()->toArray();
        $actividades = array();
        foreach ($obj as $key => $value) {
            $actividades[$value['tipo']][] = $value;
        }
 
 
        $actividades['total'][221] = count($actividades[221]); //llamada
        $actividades['total'][220] = count($actividades[220]); //Tarea
        $actividades['total'][222] = count($actividades[222]); // Reunion
        $actividades['total']['doc'] = count($objDocumentos->obtenerXrelacionId($id)); // Reunion
//        __P($actividades);
        return $actividades;
    }
 
    public function obtenerNumActividadesXMes($mes, $id) {
 
        return static::query()
                        ->selectRaw('DATE(fecha_creacion) AS fecha,COUNT(id) AS value')
                        ->whereRaw('actividad.relacionado_id=' . $id . ' AND MONTH(fecha_creacion)=' . $mes . ' GROUP BY DAY(fecha_creacion)')
//                        ->toSql();
                        ->get()->toArray();
    }
 
    public function analiticaActividadesCasos($acuerdoId) {
 
        if (!empty($acuerdoId)) {
            $bdObjeto = static::query()
                    ->selectRaw("actividad.*")
                    ->join("servicio_actividad as aa", "aa.actividad_id", "=", "actividad.id")
                    ->whereRaw("aa.servicio_id  = " . $acuerdoId)
                    ->where('actividad.activo', '=', 1)
                    ->where('actividad.eliminado', '=', 0)
                    ->where('aa.eliminado', '=', 0)
                    ->count();
 
            require_once 'modelo/Caso.php';
            $caso = new Caso();
            $numCasos = $caso->analiticaCasos($acuerdoId);
 
            return $bdObjeto + $numCasos;
        } else {
            return 0;
        }
    }
 
    public function filtrarActividades($parametros = array()) {
        global $aplicacion;
        $request = new S3Request();
        $peticion = $request->obtenerVariables();
        $registrosA = array();
 
        $objeto = static::query()
                ->selectRaw("actividad.*,tipo_rel.nombre AS tipo,(
                                        CASE
                                            WHEN DATEDIFF(fecha_fin,DATE(NOW())) < 0 THEN 'alert-danger'
                                            WHEN DATEDIFF(fecha_fin,DATE(NOW())) <= 2 && DATEDIFF(fecha_fin,DATE(NOW())) >= 0 THEN 'alert-warning'
 
                                        END) AS alerta ")
                ->join('opcion_lista_maestra as tipo_rel', 'tipo_rel.id', '=', 'actividad.tipo')
                ->where('actividad.usuario_id', '=', $aplicacion->getUsuario()->getID())
                ->where('actividad.eliminado', '=', 0)
                ->orderBy('actividad.id', 'DESC');
 
        if (sizeof($parametros) > 0) {
 
            if (!empty($parametros['nombre'])) {
                $objeto->whereRaw(" actividad.nombre like '%" . $parametros['nombre'] . "%' ");
            }
            if (isset($parametros['tipo'][0]) && sizeof($parametros['tipo']) > 0) {
 
                $tipos = "'" . implode("','", $parametros['tipo']) . "'";
                $objeto->whereRaw(' actividad.tipo in (' . $tipos . ') ');
            }
            if (!empty($parametros['fecha_desde']) && !empty($parametros['fecha_hasta'])) {
                $objeto->whereRaw(" actividad.fecha_fin between '" . $parametros['fecha_desde'] . "' AND '" . $parametros['fecha_hasta'] . "' ");
            }
 
//         __P($parametros);
        }
        $registros = $objeto->get()->toArray();
 
        for ($i = 0; $i < sizeof($registros); $i++) {
 
            $registrosA[$i]['fecha_fin'] = "<div style='padding: 6px;' class='" . $registros[$i]['alerta'] . "' >" . $registros[$i]['fecha_fin'] . "</div>";
            //$registrosA[$i]['usuario'] = $registros[$i]['usuario'];
            //$registrosA[$i]['id'] = $registros[$i]['id'];
            $registrosA[$i]['tipo'] = $registros[$i]['tipo'];
            //$registrosA[$i]['estado'] = $registros[$i]['estado'];
            $registrosA[$i]['nombre'] = '<b><a target="_blank" href="index.php?modulo=actividades&accion=editar&registro=' . $registros[$i]['id'] . '">' . $registros[$i]['nombre'] . "</a></b>";
 
            $registrosA[$i]['vacio'] = ('alert-danger' !== $registros[$i]['alerta']) ? '' : '<a target="_blank" href="index.php?modulo=actividades&accion=editar&registro=' . $registros[$i]['id'] . '" id="reprogramar_act_' . $registros[$i]['id'] . '" class="fa fa-clock-o" style="font-size: 26px; cursor:pointer; text-decoration:none;" aria-hidden="true"></a> ';
        }
 
        $listaRegistros = array(
            'data' => $registrosA,
            'draw' => $peticion['draw'],
            'recordsTotal' => $this->obtenerCount(),
            'recordsFiltered' => empty($this->cantFil) ? $this->obtenerCount() : $this->cantFil,
        );
 
        return $listaRegistros;
    }
 
    /**
     * @todo Metodo para sobreescribir el bdobjeto, en caso de que se reuieran consultas especiales
     *
     * @param object $bdObjeto
     */
    protected function prelistar(&$bdObjeto) {
        $bdObjeto->selectRaw('actividad.id,usuario.nombres usuario_id,modulo.nombre relacionado,actividad.nombre, '
                        . 'CONCAT(fecha_inicio," ",hora_inicio," ",meridiano_inicio) as fecha_inicio,'
                        . 'CONCAT(fecha_fin," ",hora_fin," ",meridiano_fin) as fecha_fin,actividad.duracion as duracion,'
                . 'tipo_llamada.nombre tipo,estado_llamada.nombre estado,actividad.lugar,actividad.fecha_creacion,'
                . 'actividad.fecha_modificacion,creado_por.nombres as creado_por,actividad.activo')
                ->leftjoin('usuario', 'usuario.id', '=', 'actividad.usuario_id')
                ->leftjoin('usuario as creado_por', 'creado_por.id', '=', 'actividad.creado_por')
                ->leftjoin('modulo', 'modulo.id', '=', 'actividad.relacionado')
                ->leftjoin('opcion_lista_maestra as estado_llamada', 'estado_llamada.id', '=', 'actividad.estado')
                ->leftjoin('opcion_lista_maestra as tipo_llamada', 'tipo_llamada.id', '=', 'actividad.tipo');
    }
}