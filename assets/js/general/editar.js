function validarFormulario() {

   if ( validarUbicacion() && validar_datos('#form_editar')) {
      return true;
   } else {
      alert('Algunos datos no son validos, por favor verifique he intente nuevamente.');
      return false;
   }
}
function validarUbicacion() {
   
   if ( s3vars.modulo == 'oportunidades') { return true; }
   var ubicacion = $("#view_ubicacion_id").val();

   if (ubicacion === '') {
      alert('Ingrese una ubicación');
      return false;
   } else {
      return true;
   }

}

function selects_dos(form) {

   if (form) {
      $('#' + form + ' select').each(function (i, o) {
         if (!$("#" + o.id).hasClass("renovar")) {

            $(o).select2();
         }
      });
   } else {
      $('#form_editar select').each(function (i, o) {
         if (!$("#" + o.id).hasClass("renovar")) {

            $(o).select2();
         }
      });
   }

}


function soloLetras(e) {
   key = e.keyCode || e.which;
   tecla = String.fromCharCode(key).toLowerCase();
   letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
   especiales = "8-37-39-46";

   tecla_especial = false;
   for (var i in especiales) {
      if (key == especiales[i]) {
         tecla_especial = true;
         break;
      }
   }

   if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
   }
}

function soloNumeros(e) {
   key = e.keyCode || e.which;
   tecla = String.fromCharCode(key).toLowerCase();
   letras = "1234567890";
   especiales = "8-37-39-46";

   tecla_especial = false;
   for (var i in especiales) {
      if (key == especiales[i]) {
         tecla_especial = true;
         break;
      }
   }

   if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
   }
}

$(document).ready(function () {
   $('#btn_agregar_precio_lista').click(function () {

    agregarprecio_lista();
  });
   $('#form_editar').keypress(function (e) {
      if (e.keyCode == 13 || e.keyCode == "13") {
         e.preventDefault();
      }
   });

   $('select').each(function (i, o) {
      $(o).select2();
   });

   $("#ubicacion_captacioni").click(function () {
      var div = $('#view_ubicacion_id');
      $(div).select2("val", "");
   });

   $('#form_editar').validationEngine({binded: true});   
   
  // $('#cuenta_id').select2('readonly',true);

   if ($("#registro_id").val() > 0 && ($("#btn_ver").val() === "" || s3vars.registro.convertido == 1)) {

      $(".ver_js").css({display: "inline"});
      $(".editar_js").css({display: "none"});
   } else {
      $(".ver_js").css({display: "none"});

   }

   $("#btn_ver").click(function () {
      $(".ver_js").css({display: "none"});
      $(".editar_js").css({display: "inline"});

      $(".panel_derecho").addClass("hidden");
      $(".panel_principal").removeClass("col-sm-9").addClass("col-sm-12");

      $("#nuevo_caso").remove();
      $("#nuevo_documento").remove();
      $("#nuevo_actividad").remove();
      $("#nueva_cotizacion").remove();
      $("#nueva_oportunidad").remove();

      $("#listar_casos").remove();
      $("#lista_contactos").remove();
      $("#lista_cotizaciones").remove();
      $("#lista_oportunidades").remove();
      $("#lista_actividades").remove();
      $("#lista_documentos").remove();
   });
});


function autocompletarUbicacion(div) {

   var ubicacion = 0;
   if (typeof s3vars.registro != "undefined" && typeof s3vars.registro.view_ubicacion_id != "undefined") {
      ubicacion = s3vars.registro.view_ubicacion_id + '';
   }
   $(div).select2({
      minimumInputLength: 2,
//        tags: [], //hacerlo multiselect
      ajax: {
         url: 'index.php?modulo=ubicaciones&accion=autocompletar',
         dataType: 'json',
         type: "POST",
         data: function (term) {
            return {
               palabra: term
            };
         },
         results: function (data) {
            return {
               results: $.map(data, function (item) {
                  return {
                     text: item.ubicacion,
                     id: item.id
                  }
               })
            };
         },
      },
      initSelection: function (element, callback) {
         var elementText = $('#view_ubicacion_nombre').val();
         callback({id: $(element).val(), text: elementText});
      }
   }).on('change', function (e) {
      ubicacion = e.val;
   });
}


// CARGAR UN NUEVO INVITADO
function agregarInvitado_act() {
   console.log("ARGAR UN NUEVO INVITADO");
   option_cuenta = '';

//var html = '<div class="form-group col-sm--12">' +
//            '<input type="hidden" class="id" name="item_meta_id[]" value="">' +
//            '<input type="hidden" class="eliminado" name="meta_eliminado[]" value="0">' +

   var html = '<div  class="col-sm-12 form-group">' +
           '<input type="hidden" class="eliminado" name="invitado_eliminado[]" value="0">' +
           '<input class="id" type="hidden" id="id_invitado" name="id_invitado[]" >' +
           '<div class=" col-sm-2">' +
           '<select class="form-control required renovar" id="modulo_actividad" name="modulo_actividad[]" onchange="t_modulo_actividad_act(this)">' +
           '<option value="-1">Seleccionar</option>' +
           '<option value="1">Clientes</option>' +
           '<option value="2">Contactos</option>' +
           '<option value="3">Usuarios</option>' +
           '</select>' +
           '</div>' +
           '<div class=" col-sm-5">' +
           '<select class="form-control required renovar" id="nombre_actividad" name="nombre_actividad[]" onchange="obtener_email_actividad(this)">' +
           '<option value="-1">Seleccionar</option>' +
           '</select>' +
           '</div>' +
           '<div class="col-sm-4 ">' +
           '<input class="form-control required" type="email" id="email_actividad"  name="email_actividad[]">' +
           '</div>' +
           '<div class="col-sm-1 ">' +
//            '<button type="button"  onclick="del_invitado(this);" class="btn btn_eliminar_reg_invitado_act btn-primary  btn-xs"><i class="fa fa-minus"></i></button> ' +
           '<button type="button"  class="btn btn_eliminar_reg_invitado_act btn-primary  btn-xs"><i class="fa fa-minus"></i></button> ' +
           '</div>' +
           '</div>';
   $('#invitados').append(html);

   triggersInvitado_act();
}

function triggersInvitado_act() {
   $('.btn_eliminar_reg_invitado_act').on('click', function () {
      eliminarCampoRegistroInvitado_act($(this).parent().parent());
   });

}

function eliminarCampoRegistroInvitado_act(div) {
   if ($(div).find('.id').val() > 0 && $(div).find('.id').val() != "" && $(div).find('.id').val() != "0") {
      $(div).find('.eliminado').val(1);
      $(div).addClass('hidden');
   } else {
      $(div).remove();
   }
}


function t_modulo_actividad_act(obj) {
//define la lista de cliente o de usuarios

//$($(obj).parent().parent()[0]['children'][3]['children'][0]).html('');

   option = '';
   option = '<option value="-1">Seleccionar</option>';
   if ($(obj).val() == '1') {
      for (i = 0; i < s3vars.cuentas_calendario.length; i++) {
         option += '<option value="' + s3vars.cuentas_calendario[i]['id'] + '">' + s3vars.cuentas_calendario[i]['nombre'] + '</option>';
      }
   }
   if ($(obj).val() == '2') {
      for (i = 0; i < s3vars.contactos_calendario.length; i++) {
         $($(obj).parent().parent()[0]['children'][3]['children'][0]).select2('data', {id: s3vars.contactos_calendario[i]['id'], text: s3vars.contactos_calendario[i]['nombre']});
         option += '<option value="' + s3vars.contactos_calendario[i]['id'] + '">' + s3vars.contactos_calendario[i]['nombre'] + '</option>';
      }
   }
   if ($(obj).val() == '3') {
      for (i = 0; i < s3vars.usuarios_calendario.length; i++) {
         option += '<option value="' + s3vars.usuarios_calendario[i]['id'] + '">' + s3vars.usuarios_calendario[i]['nombre'] + '</option>';
      }
   }
   //$($(obj).parent().parent()[0]['children'][3]['children'][0]).select2('data',{id: 1, text: 's3vars.contactos'});
   //$("#select2").select2('data', {id: newID, text: newText});    


   $($(obj).parent().parent()[0]['children'][3]['children'][0]).append(option);
   $($(obj).parent().parent()[0]['children'][3]['children'][0]).select2("val", "-1");

   $($(obj).parent().parent()[0]['children'][4]['children'][0]).val("");
//    $($($(obj).parent().parent()[0]['children'][3]).children()[1][0]).html('');
//    console.log($($($(obj).parent().parent()[0]['children'][3]).children()[1]));
//    $($($(obj).parent().parent()[0]['children'][3]).children()[1][0]).append(option);
}

function obtener_email_actividad(obj) {
   var registro_select_id = $(obj).val();
   var selct_modulo = $($(obj).parent().parent()[0]['children'][2]['children'][0]).val();

   if (selct_modulo == '1') {
      for (i = 0; i < s3vars.cuentas_calendario.length; i++) {
         if (registro_select_id == s3vars.cuentas_calendario[i]['id']) {
            $($(obj).parent().parent()[0]['children'][4]['children'][0]).val(s3vars.cuentas_calendario[i]['correo']);
         }
      }
   }
   if (selct_modulo == '2') {
      for (i = 0; i < s3vars.contactos_calendario.length; i++) {
         if (registro_select_id == s3vars.contactos_calendario[i]['id']) {
            $($(obj).parent().parent()[0]['children'][4]['children'][0]).val(s3vars.contactos_calendario[i]['correo']);
         }

      }
   }
   if (selct_modulo == '3') {
      for (i = 0; i < s3vars.usuarios_calendario.length; i++) {
         if (registro_select_id == s3vars.usuarios_calendario[i]['id']) {
            $($(obj).parent().parent()[0]['children'][4]['children'][0]).val(s3vars.usuarios_calendario[i]['correo']);
         }
      }
   }

}

