<?php

if (!defined('s3_entrada') || !s3_entrada) {
   die('No es un punto de entrada valido');
}

class ListaMaestra extends S3TablaBD {

   protected $table = 'lista_maestra';

   protected function preguardar(&$bdObjeto) {
      parent::preguardar($bdObjeto);

      $request = new S3Request();
      $vars = $request->obtenerVariables();

      if ($bdObjeto->modulo_id == '-1' || ($vars['general'] > 0 && !isset($vars['modulo_id']))) {
         $bdObjeto->modulo_id = NULL;
      }

      $bdObjeto->etiqueta = strtolower($bdObjeto->etiqueta);

      if (empty($vars['general'])) {
         $bdObjeto->general = 0;
      }
   }

   protected function postguardar(&$bdObjeto) {
      parent::postguardar($bdObjeto);

      require_once 'modelo/OpcionListaMaestra.php';
      $objOpcLisMae = new OpcionListaMaestra();

      $objOpcLisMae->guardar($bdObjeto->id);
   }

   public function obtenerRegistro($registro) {
      $reg = parent::obtenerRegistro($registro);

      require_once 'modelo/OpcionListaMaestra.php';
      $objOpcLisMae = new OpcionListaMaestra();

      $reg['opciones'] = $objOpcLisMae->obtenerOpcionesxListaId($reg['id']);

      return $reg;
   }

   protected function prelistar(&$bdObjeto) {
      $bdObjeto->selectRaw("lista_maestra.id, lista_maestra.nombre, lista_maestra.etiqueta, IF(m.nombre != '', m.nombre, 'General') as Modulo, lista_maestra.activo")
              ->leftJoin('modulo as m', 'm.id', '=', 'lista_maestra.modulo_id')
              ->whereRaw("lista_maestra.activo = 1  and lista_maestra.eliminado = 0 ");
   }

}
