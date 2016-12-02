$(document).ready(function () {

  $('#form_editar').validationEngine();
  $("#toma_contacto_id").change(function () {

    if ($("#toma_contacto_id").val() == 7) {
      $("#referido_por").parent().parent().parent().removeClass('hidden');
    } else {
      $("#referido_por").parent().parent().parent().addClass('hidden');
    }

  });
 
   $(".modal-transparent").on('show.bs.modal', function () {
      setTimeout(function () {
         $(".modal-backdrop").addClass("modal-backdrop-transparent");
      }, 0);
   });
   $(".modal-transparent").on('hidden.bs.modal', function () {
      $(".modal-backdrop").addClass("modal-backdrop-transparent");
   });
 
  var div = $('#view_ubicacion_id');
  autocompletarUbicacion(div);

  $('#crear_oportunidad').click(function (k, v) {
    if ($("#crear_oportunidad").is(':checked')) {
      $("#crear_oportunidad").val(1);
      $("#referencia").addClass("validate[required]");
      $("#valor").addClass("validate[required]");
      $("#etapa_id").addClass("validate[required]");
      $("#fecha_cierre").addClass("fecha validate[required,custom[date],funcCall[comparaConFechaActual[#fecha_cierre]]]");
    } else {
      $("#crear_oportunidad").val(0);
      $("#referencia").removeClass("validate[required]");
      $("#valor").removeClass("validate[required]");
      $("#etapa_id").removeClass("validate[required]");
      $("#fecha_cierre").removeClass("fecha validate[required,custom[date],funcCall[comparaConFechaActual[#fecha_cierre]]]");
      $("#opp_descripcion").removeClass("validate[required]");

    }
    //$("#checkbox").attr('checked', true);  
  });

  agregarInvitado_act();
  
  if(s3vars.convertido == 1){
     $('#modal-transparent').modal('toggle');
               setTimeout(function () {
                  $('#modal-transparent').modal('toggle');
               }, 6000);
  }
});

