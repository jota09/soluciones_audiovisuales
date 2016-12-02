<?php

if (!defined('s3_entrada') || !s3_entrada) {
   die('No es un punto de entrada valido');
}

class Oportunidad extends S3TablaBD {

   protected $table = 'oportunidad';

   public function obtenerListaRegistros($where = array(0 => array('columna' => 'eliminado', 'condicional' => '=', 'valor' => 0)), $ajaxTabla = false, $only = false) {

      $bdObjeto = static::query()
              ->selectRaw("oportunidad.id, oportunidad.referencia, TRIM(CONCAT(IFNULL(cta.nombres,cta.nombre_comercial),' ',IFNULL(cta.apellidos,''))) AS cuenta, FORMAT(oportunidad.valor, 0) as valor,op.nombre AS etapa, op2.nombre AS 'toma contacto', CONCAT(us.nombres,' ',us.apellidos) AS asesor,oportunidad.fecha_cierre as 'fecha cierre'")
              ->join('opcion_lista_maestra AS op', 'op.id', '=', 'oportunidad.etapa_id')
              ->join('opcion_lista_maestra AS op2', 'op2.id', '=', 'oportunidad.toma_contacto_id')
              ->join('cuenta AS cta', 'cta.id', '=', 'oportunidad.cuenta_id')
              ->join('usuario AS us', 'us.id', '=', 'oportunidad.asesor_asignado_id');
      
      $filtro = array
        (  "filtroEtapa"  => "op",
           "filtroTomaContacto" => "op2",
           "filtroCuenta" => "cta",
           "filtroAsignado" => "us"
        
        );     
      if ($ajaxTabla) {
         $this->obtenerListaRegistrosAjaxTablaAux($bdObjeto,$filtro);
      }

      if ($only) {
         $bdObjeto->take(1)->skip(0);
      }
      $bdObjeto->orderBy($this->table . '.id', 'DESC');
      $arrayCli = $bdObjeto->get()->toArray();

      if ($ajaxTabla) {
         $this->postObtenerListaRegistrosAjaxTabla($arrayCli);
      }

      return $arrayCli;
   }
   public function obtenerListaRegistrosxCuenta($id) {

      $bdObjeto = static::query()
              ->selectRaw("oportunidad.id, oportunidad.referencia, TRIM(CONCAT(IFNULL(cta.nombres,cta.nombre_comercial),' ',IFNULL(cta.apellidos,''))) AS cuenta, FORMAT(oportunidad.valor, 0) as valor,op.nombre AS etapa, op2.nombre AS 'toma contacto', CONCAT(us.nombres,' ',us.apellidos) AS asesor,oportunidad.fecha_cierre as 'fecha cierre'")
              ->join('opcion_lista_maestra AS op', 'op.id', '=', 'oportunidad.etapa_id')
              ->join('opcion_lista_maestra AS op2', 'op2.id', '=', 'oportunidad.toma_contacto_id')
              ->join('cuenta AS cta', 'cta.id', '=', 'oportunidad.cuenta_id')
              ->join('usuario AS us', 'us.id', '=', 'oportunidad.asesor_asignado_id')
              ->leftjoin('oportunidad_contacto AS oc', 'oportunidad.id', '=', 'oc.oportunidad_id')
              ->where('cta.id', '=', $id)
              ->whereRaw('oc.id IS NULL');
      $bdObjeto->orderBy($this->table . '.id', 'DESC');
      $arrayCli = $bdObjeto->get()->toArray();
//      __P($bdObjeto->toSql());


      return $arrayCli;
   }
   

   public function obtenerRegistro($registro) {
      //require_once 'modelo/Actividades.php';
      //$objActividades = new Actividades();
      $reg = parent::obtenerRegistro($registro);

      $reg['valor'] = number_format($reg['valor'], 0, ".", ",");
      //$reg['actividades'] = $objActividades->obtenerActividadesXrelacionId($registro);
      return $reg;
   }

   public function misNegociaciones() {
      global $aplicacion;

      $valor = 0;
      $bdObjeto = static::query()
                      ->selectRaw("oportunidad.*,etapa_rel.nombre as etapa_nombre, CONCAT(u.nombres,' ',u.apellidos) AS asignado")
                      ->join('opcion_lista_maestra AS etapa_rel', 'etapa_rel.id', '=', 'oportunidad.etapa_id')
                      ->join('usuario AS u', 'u.id', '=', 'oportunidad.asesor_asignado_id')
                      ->where('oportunidad.creado_por', '=', $aplicacion->getUsuario()->getID())
                      ->where('oportunidad.eliminado', '=', 0)
                      ->where('oportunidad.activo', '=', 1)
                      ->orderBy('oportunidad.id', 'DESC')
                      ->get()->toArray();

      foreach ($bdObjeto as $k => $v) {
         $valor += $v['valor'];
      }

      if ($valor > 0 && sizeof($bdObjeto) > 0) {
         $bdObjeto[0]['valor_total'] = $valor;
      }

      return $bdObjeto;
   }

//traer los documentos por modulo y id
   public function obtener_relacionados($parametros) {
      if ($parametros['modulo_name'] == 'clientes_potenciales') {

         $bdObjeto = static::query()
                 ->selectRaw('oportunidad.*')
                 ->where('oportunidad.eliminado', '=', 0)
                 ->where('oportunidad.cliente_potencial_id', '=', $parametros['modulo_id'])
                 ->where('oportunidad.activo', '=', 1)
                 ->get();
      }
      if ($parametros['modulo_name'] == 'contactos') {

         $bdObjeto = static::query()
                 ->selectRaw('oportunidad.*,olm.nombre as nombre_rol')
                 ->join('oportunidad_contacto AS oc', 'oc.oportunidad_id', '=', 'oportunidad.id')
                 ->join('opcion_lista_maestra AS olm', 'olm.id', '=', 'oc.rol_id')
                 ->where('oc.contacto_id', '=', $parametros['modulo_id'])
                 ->where('oportunidad.eliminado', '=', 0)
                 ->where('oc.eliminado', '=', 0)
                 ->where('oportunidad.activo', '=', 1)
                 ->get();
      }
      if ($parametros['modulo_name'] == 'cuentas') {

         $bdObjeto = static::query()
                 ->selectRaw('oportunidad.*')
                 ->where('oportunidad.cuenta_id', '=', $parametros['modulo_id'])
                 ->where('oportunidad.eliminado', '=', 0)
                 ->where('oportunidad.activo', '=', 1)
                 ->get();
      }
      if ($parametros['modulo_name'] == 'convenios') {

         $bdObjeto = static::query()
                 ->selectRaw('oportunidad.*')
                 ->where('oportunidad.convenio_id', '=', $parametros['modulo_id'])
                 ->where('oportunidad.eliminado', '=', 0)
                 ->where('oportunidad.activo', '=', 1)
                 ->get();
      }

      $lista = $bdObjeto->toArray();
      $tmp = Array();
      //preformatea lo que se va a imprimir
      for ($i = 0; $i < count($lista); $i++) {
         $tmp[$i]['id'] = $lista[$i]['id'];
         $tmp[$i]['referencia'][] = $lista[$i]['referencia'];
         $tmp[$i]['valor'][] = $lista[$i]['valor'];
         $tmp[$i]['fecha_cierre'][] = $lista[$i]['fecha_cierre'];
         $tmp[$i]['eliminado'] = '<i class=" fa fa-minus"></i>';
         if(isset($lista[$i]['nombre_rol'])){
         $tmp[$i]['nombre_rol'][] = $lista[$i]['nombre_rol'];
         
         }
      }
      if(isset($lista[0]['nombre_rol'])){

      $array['campos'] = Array
          (
          '0' => Array
              (
              'data' => 'id',
              'mData' => 'id'
          ),
          '1' => Array
              (
              'data' => 'referencia',
              'mData' => 'referencia'
          ),
          '2' => Array
              (
              'data' => 'valor',
              'mData' => 'valor'
          ),
          '3' => Array
              (
              'data' => 'fecha_cierre',
              'mData' => 'fecha_cierre'
          ),
          '4' => Array
              (
              'data' => 'nombre_rol',
              'mData' => 'nombre_rol'
          ),
          '5' => Array
              (
              'data' => 'eliminado',
              'mData' => 'eliminado'
          )
      );
      }
      else {
         
         $array['campos'] = Array
          (
          '0' => Array
              (
              'data' => 'id',
              'mData' => 'id'
          ),
          '1' => Array
              (
              'data' => 'referencia',
              'mData' => 'referencia'
          ),
          '2' => Array
              (
              'data' => 'valor',
              'mData' => 'valor'
          ),
          '3' => Array
              (
              'data' => 'fecha_cierre',
              'mData' => 'fecha_cierre'
          ),
          '4' => Array
              (
              'data' => 'eliminado',
              'mData' => 'eliminado'
          )
      );
      }
      $array['count_opps'] = count($tmp);
      $array['opps'] = $tmp;

      return $array;
   }

   public function convertirOportunidad($informacion, $cuenta) {
      global $aplicacion;
      $this->cargarCampos();

      $variablesPost = $informacion;
      $bdObjeto = $this;
      $variablesPost['valor']=str_replace(',','',$variablesPost['valor']);
      foreach ($variablesPost as $variablePost => $valorPost) {
         if (in_array($variablePost, $this->camposTabla)) {
            $bdObjeto->$variablePost = (empty($valorPost)) ? NULL : $valorPost;
         }
      }

      $bdObjeto->cuenta_id = $cuenta;
      $bdObjeto->asesor_asignado_id = $variablesPost['asesor_id'];
      $bdObjeto->descripcion = $variablesPost['opp_descripcion'];
      $bdObjeto->cliente_potencial_id = $variablesPost['registro_id'];

      if (in_array('creado_por', $this->camposTabla)) {
         $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
      }
      if (in_array('fecha_creacion', $this->camposTabla)) {

         $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
      }
//      __P($bdObjeto);
      $bdObjeto->save();
      $this->postguardar($bdObjeto);

      return $bdObjeto;
   }

   protected function preguardar(&$bdObjeto) {
      parent::preguardar($bdObjeto);

      $request = new S3Request();

      $variablesPost = $request->obtenerVariables();

      $bdObjeto->valor = str_replace(",", "", $variablesPost['valor']);
      $bdObjeto->linea_id = "";
      $bdObjeto->linea_str = "";
      $bdObjeto->etapa_id = $variablesPost['etapa_opp_id'];

      foreach ($variablesPost['linea'] as $k => $v) {
         $ln = explode("-", $v);
         $bdObjeto->linea_id .= $ln[0] . ((($k + 1 ) == sizeof($variablesPost['linea'])) ? ' ' : ', ');
         $bdObjeto->linea_str .= $ln[1] . ((($k + 1 ) == sizeof($variablesPost['linea'])) ? ' ' : ', ');
      }
   }

   public function valorGanadas($oportunidad) {
      $bdObjeto = static::query()
              ->selectRaw('sum(valor) as total')
              ->whereRaw('cuenta_id = ' . $oportunidad)
              ->where('eliminado', '=', 0)
              ->where('activo', '=', 1)
              ->where('etapa_id', '=', 19)
              ->get();

      $registro = $bdObjeto->toArray();
      return number_format($registro[0]['total']);
   }

   public function obtenerOportunidadxCuenta($cuentaId) {

      $bdObjeto = static::query()
              ->selectRaw('oportunidad.*')
              ->where('oportunidad.cuenta_id', '=', $cuentaId)
              ->where('oportunidad.eliminado', '=', 0)
              ->where('oportunidad.activo', '=', 1)
              ->orderBy('oportunidad.id', 'DESC')
              ->get();

      $lista = $bdObjeto->toArray();

      return $lista;
   }

   public function obtenerOportunidadesxCuenta($parametros) {

      if ($parametros['modulo_name'] == 'cuentas') {

         $bdObjeto = static::query()
                 ->selectRaw('oportunidad.*')
                 ->where('oportunidad.cuenta_id', '=', $parametros['modulo_id'])
                 ->where('oportunidad.eliminado', '=', 0)
                 ->where('oportunidad.activo', '=', 1)
                 ->orderBy('oportunidad.id', 'DESC')
                 ->get();
      }

      $lista = $bdObjeto->toArray();

      return $lista;
   }

   public function obtenerOportunidadesGanadasXMes($parametros) {

      $bdObjeto = static::query()
              ->selectRaw('month(IFNULL(oportunidad.fecha_modificacion, oportunidad.fecha_creacion)) as mes, YEAR(oportunidad.fecha_creacion) as annio, count(oportunidad.id) as value, IFNULL(oportunidad.fecha_modificacion, oportunidad.fecha_creacion) as fecha')
              ->where('oportunidad.cuenta_id', '=', $parametros['id'])
              ->where('oportunidad.eliminado', '=', 0)
              ->where('oportunidad.activo', '=', 1)
              ->where('oportunidad.etapa_id', '=', 19)
              ->groupBy('mes')->orderBy('annio', 'DESC')->orderBy('mes', 'DESC')
              ->get();

      $fin = $parametros['mes'];
      $ini = $fin - 5;
      if ($ini < 1) {
         $ini += 12;
      }

      $lista = array_reverse($bdObjeto->toArray());
      $arrafecha = explode("-", $lista[0]['fecha']);
      if ($ini < $fin) {
         $anno = $arrafecha[0];
      } else {
         $anno = $arrafecha[0] - 1;
      }
      $registros = array();
      $pos = 0;
      while ($ini != $fin + 1) {

         if ($ini == 13) {
            $ini = 1;
            $anno++;
         }

         if (strlen($ini) == 1) {
            $mes = '0' . $ini;
         } else {
            $mes = $ini;
         }
         if (isset($lista[$pos]['mes']) && $lista[$pos]['mes'] == $ini) {
            $arrafecha = explode(" ", $lista[$pos]['fecha']);
            $lista[$pos]['fecha'] = $arrafecha[0];
            $registros[] = array(
                'value' => $lista[$pos]['value'],
                'fecha' => $lista[$pos]['fecha']
            );
            $pos++;
         } else {
            $registros[] = array(
                'value' => 0,
                'fecha' => $anno . '-' . $mes . '-19'
            );
         }
         $ini++;
      }

      return $registros;
   }

   public function analiticaOportunidadesConvenio($parametros) {

      if (!empty($parametros)) {
         $bdObjeto = static::query()
                 ->selectRaw('oportunidad.*')
                 ->where('oportunidad.convenio_id', '=', $parametros)
                 ->where('oportunidad.eliminado', '=', 0)
                 ->where('oportunidad.activo', '=', 1)
                 ->orderBy('oportunidad.id', 'DESC')
                 ->count();

         return $bdObjeto;
      } else {
         return 0;
      }
   }

   public function obtenerOportunidadesXConvenio($parametros) {

      $bdObjeto = static::query()
              ->selectRaw('month(oportunidad.fecha_creacion) as mes, count(oportunidad.id) as cantidad')
              ->where('oportunidad.convenio_id', '=', $parametros['id'])
              ->whereRaw(' YEAR(oportunidad.fecha_creacion)  = ' . $parametros['annio'])
              ->where('oportunidad.eliminado', '=', 0)
              ->where('oportunidad.activo', '=', 1)
              ->groupBy('mes')->orderBy('mes', 'ASC')
              ->get();

      $listaRegistros = $bdObjeto->toArray();
      $registros = array();
      $pos = 0;
      $j = 1;
      for ($i = 1; $i < 13; $i++) {

         if ($listaRegistros[$pos]['mes'] == $i) {

            $cantidadFinal += $listaRegistros[$pos]['cantidad'];
            $pos++;
         } else {
            $cantidadFinal += 0;
         }
         if ($i % 3 == 0) {
            $registros[] = array(
                'value' => $cantidadFinal,
                'fecha' => "Trimestre " . $j
            );
            $j++;
            $cantidadFinal = 0;
         }
      }

      return $registros;
   }

   public function filtrarOportunidades($parametros = array()) {
      global $aplicacion;
      $request = new S3Request();
      $peticion = $request->obtenerVariables();
      $registrosA = array();

      $objeto = static::query()
              ->selectRaw("oportunidad.*,etapa_rel.nombre as etapa, CONCAT(u.nombres,' ',u.apellidos) AS asignado")
                      ->join('opcion_lista_maestra AS etapa_rel', 'etapa_rel.id', '=', 'oportunidad.etapa_id')
                      ->join('usuario AS u', 'u.id', '=', 'oportunidad.asesor_asignado_id')
                      ->where('oportunidad.creado_por', '=', $aplicacion->getUsuario()->getID())
                      ->where('oportunidad.eliminado', '=', 0)
                      ->where('oportunidad.activo', '=', 1)
                      ->orderBy('oportunidad.id', 'DESC');

      if (sizeof($parametros) > 0) {

         if (!empty($parametros['referencia'])) {
            $objeto->whereRaw(" oportunidad.referencia like '%" . $parametros['referencia'] . "%' ");
         }
         if (isset($parametros['etapa'][0]) && sizeof($parametros['etapa']) > 0) {

            $etapa = "'" . implode("','", $parametros['etapa']) . "'";
            $objeto->whereRaw(' oportunidad.etapa_id in (' . $etapa . ') ');
         }
         if (isset($parametros['asignado'][0]) && sizeof($parametros['asignado']) > 0) {

            $asignado = "'" . implode("','", $parametros['asignado']) . "'";
            $objeto->whereRaw(' oportunidad.asesor_asignado_id in (' . $asignado . ') ');
         }

         // __P($objeto->toSql());
      }
      $registros = $objeto->get()->toArray();

      for ($i = 0; $i < sizeof($registros); $i++) {

         
         $registrosA[$i]['asignado'] = $registros[$i]['asignado'];
         $registrosA[$i]['vacio'] = "";
         $registrosA[$i]['etapa'] = $registros[$i]['etapa'];
         $registrosA[$i]['valor'] = number_format($registros[$i]['valor'], 0, ".", ",");
         $registrosA[$i]['nombre'] = '<b><a target="_blank" href="index.php?modulo=oportunidades&accion=editar&registro=' . $registros[$i]['id'] . '">' . $registros[$i]['referencia'] . "</a></b>";
         
      }

      $listaRegistros = array(
          'data' => $registrosA,
          'draw' => $peticion['draw'],
          'recordsTotal' => $this->obtenerCount(),
          'recordsFiltered' => empty($this->cantFil) ? $this->obtenerCount() : $this->cantFil,
      );

      return $listaRegistros;
   }
   
   protected function obtenerListaRegistrosAjaxTablaAux(&$bdObjeto, $filtro) {
       require_once 'Filtro.php';
  }
  
  public function guardarOportunidad() {
     global $aplicacion;
        $this->cargarCampos();

        $request = new S3Request();
        $registroId = $request->obtenerVariablePGR('registro_id');
        $variablesPost = $request->obtenerVariables();
        $bdObjeto = $this;
        foreach ($variablesPost as $variablePost => $valorPost) {
            if (in_array($variablePost, $this->camposTabla)) {
                $bdObjeto->$variablePost = (empty($valorPost)) ? NULL : $valorPost;
            }
        }

        if (in_array('creado_por', $this->camposTabla)) {
                $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
            }
            if (in_array('fecha_creacion', $this->camposTabla)) {

                $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
            }

            $this->preguardar($bdObjeto);
            $bdObjeto->save();
            if (isset($variablesPost['rol_id'])){
               $this->postguardarModal($bdObjeto->id); 
                
            }
            else {
            $this->postguardar($bdObjeto); }
        
  }
  
  public function postguardar(&$bdObjeto) {
     parent::postguardar($bdObjeto);
     
  }
  public function postguardarModal($id) {
    $request = new S3Request();
    $variablesPost = $request->obtenerVariables();
    $variablesRelacion['contacto_id']= $variablesPost['contacto_id'];  
    $variablesRelacion['oportunidad_id']= $id;  
    $variablesRelacion['rol_id']= $variablesPost['rol_id'];  
    require_once 'modelo/Oportunidad_contacto.php';
    $opp_contacto = new OportunidadContacto();
//    __P($variablesPost);
    $opp_contacto->guardar_opp_contact($variablesRelacion);
    
  }

}
