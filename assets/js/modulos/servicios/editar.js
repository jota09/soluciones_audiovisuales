$(document).ready(function () {
  $('#form_editar').validationEngine();
  $('#cuenta_id').select2('readonly', false);

  $("#toma_contacto_id").change(function () {

    if ($("#toma_contacto_id").val() == 7) {
      $("#referido_por").parent().parent().parent().removeClass('hidden');
    } else {
      $("#referido_por").parent().parent().parent().addClass('hidden');
    }

  });

  var div = $('#view_ubicacion_id');
  autocompletarUbicacion(div);

  $("#tipo_acuerdo_id").change(function (k, v) {
    estructurarFormulario();
  });
  estructurarFormulario();

  agregarInvitado_act();
});

function estructurarFormulario() {
  var tipoAcuerdo = $("#tipo_acuerdo_id").val();

  $.each($("#form_editar .form-control"), function (ks, vs) {
    if (tipoAcuerdo == 58) { //  CONVENIO
      if ($("#" + vs.id).hasClass("cnvn")) {
        $("#" + vs.id).parent().parent().parent().removeClass("hidden");
      }
      if ($("#" + vs.id).hasClass("srvc")) {
        $("#" + vs.id).parent().parent().parent().addClass("hidden");
      }

      $(".lbl_cnvn").removeClass("hidden");
      $(".lbl_srvc").addClass("hidden");
    } else if (tipoAcuerdo == 57) { // SERVICIO
      if ($("#" + vs.id).hasClass("cnvn")) {
        $("#" + vs.id).parent().parent().parent().addClass("hidden");
      }
      if ($("#" + vs.id).hasClass("srvc")) {
        $("#" + vs.id).parent().parent().parent().removeClass("hidden");
      }

      $(".lbl_cnvn").addClass("hidden");
      $(".lbl_srvc").removeClass("hidden");
    }
  });

}





