<?php

if (!defined('s3_entrada') || !s3_entrada) {
  die('No es un punto de entrada valido');
}

class Invitados extends S3TablaBD {

  protected $table = 'invitado';

  public function guardar($bdObjeto) {


    $request = new S3Request();
    $post = $request->obtenerVariables();

    if (count($_REQUEST['id_invitado']) > 0) {
      foreach ($post['id_invitado'] as $k => $v) {          
        $objInvitado = new Invitados();
        if (!empty($v)) {

          $objInvitado = static::query()
                  ->find($v);
          $objInvitado->modulo_actividad = $post['modulo_actividad'][$k];
          $objInvitado->nombre_actividad = $post['nombre_actividad'][$k];
          $objInvitado->email_actividad = $post['email_actividad'][$k];
          $objInvitado->eliminado = $post['invitado_eliminado'][$k];
          $objInvitado->actividad_id = $bdObjeto;


          $objInvitado->update();
        } else {
          $objInvitado->modulo_actividad = $post['modulo_actividad'][$k];
          $objInvitado->nombre_actividad = $post['nombre_actividad'][$k];
          $objInvitado->email_actividad = $post['email_actividad'][$k];
          $objInvitado->eliminado = $post['invitado_eliminado'][$k];
          $objInvitado->actividad_id = $bdObjeto;
          $objInvitado->save();
        }
      }
    }
  }

  public function obtenerInvitadosxActividad($idActividad) {

    $bdObjeto = static::query()
            ->selectRaw('invitado.*')
            ->join('actividad', 'actividad.id', '=', 'invitado.actividad_id')
            ->whereRaw('(invitado.eliminado=? AND invitado.actividad_id=?)', array(0, $idActividad))
            ->get();
    return $bdObjeto->toArray();
  }

}
