window.onload = function () {

   if (s3vars.registro.toma_contacto_id == 7) {
      $("div .referido").removeClass('hidden');
   } else {
      $("div .referido").addClass('hidden');
   }
   $('#cuenta_id').select2('readonly', false);

};
   
$(document).ready(function () {
   setTimeout(function () {
                  $('#form_cont #cuenta_id2').select2('readonly', false);
   $('#form_cont #asesor_id').select2('readonly', false);
               }, 1500);
   $('#form_editar').validationEngine();

   tipoNaturaleza(s3vars.registro.naturaleza_id);

   $('#naturaleza_id').change(function () {
      tipoNaturaleza($(this).val());
   });
   $('.number').number(true, 0, '.', ',');
   $("#toma_contacto_id").change(function () {

      if ($("#toma_contacto_id").val() == 7) {
         $("#referido_por").parent().parent().parent().removeClass('hidden');
      } else {
         $("#referido_por").parent().parent().parent().addClass('hidden');
      }

   });

   var div = $('#view_ubicacion_id');
   autocompletarUbicacion(div);

   agregarInvitado_act();
});

function cambioTipoDocumento(myArray) {
   console.log(myArray);
   if (!s3vars.registro.tipo_documento_id) {
      $("#tipo_documento_id").select2("val", '');
   }

   $('#tipo_documento_id option').each(function (k, v) {
      $(v).removeAttr('disabled');
      if (myArray.indexOf($(v).val()) >= 0) {
         $(v).attr('disabled', 'disabled');
      }
   });
   s3vars.registro.tipo_documento_id = null;
}
function tipoNaturaleza(op) {
   console.log(op)
   switch (op) {
      case 34:
      case "34":
         var myArray = ['35'];
         cambioTipoDocumento(myArray);
         $('.cliente_juridico').css({'display': 'none'});
         $('#nombre_comercial').removeClass('validate[required]');
         $('#nombres').addClass('validate[required]');
         $('#apellidos').addClass('validate[required]');
         $('.cliente_natural').css({'display': 'block'});

         break;
      case 33:
      case "33":

         $('#nombre_comercial').addClass('validate[required]');
         $('#nombres').removeClass('validate[required]');
         $('#apellidos').removeClass('validate[required]');
         var myArray = ['36', '37'];
         cambioTipoDocumento(myArray);
         $('.cliente_juridico').css({'display': 'block'});
         $('.cliente_natural').css({'display': 'none'});
         break;
      default:

         $('.cliente_juridico').css({'display': 'none'});
         $('.cliente_natural').css({'display': 'none'});
         break;
   }
}

