id_calendario = '#calendarioNiceCRM';

function renderCalendar() {

  $(id_calendario).fullCalendar({
    defaultView: 'agendaWeek',
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
    eventClick: function (event, jsEvent, view) {

      obtenerDialogoActividad(cargarEventos(event.id), event);
      campos_tipo_calendario();
    },
    editable: true,
    selectable: true,
    eventDragStop: function (event, jsEvent, ui, view) {
//            console.log(jsEvent);
      bootbox.confirm(s3vars.L_MOD.lbl_confirmacion, function (result) {
        if (result) {
          var actualizar = actulizarDataDropStopReSize(event);
          cargarEventos(event.id, actualizar);
        } else {
          $(id_calendario).fullCalendar('destroy');
          renderCalendar(id_calendario);
        }

      });
    },
    eventResize: function (event, delta, revertFunc) {

      bootbox.confirm(s3vars.L_MOD.lbl_confirmacion_hora, function (result) {
        if (result) {
          var actualizar = actulizarDataDropStopReSize(event);
          cargarEventos(event.id, actualizar);
        } else {
          revertFunc();
        }
      });

    },
    select: function (start, end) {
//            console.log(moment(start._d).format("YYYY-MM-DD"));
//            console.log(moment(end._d).format("YYYY-MM-DD"));
      var fechaActual = new Date();

      var hora = fechaActual.getHours();
      var meridiano = "AM";
      var minutos = fechaActual.getMinutes();
      if (parseInt(minutos) > 45 && parseInt(minutos) < 60) {
        hora += 1;
      } else if (parseInt(minutos) > 30 && parseInt(minutos) < 46) {
        minutos = 45;
      } else if (parseInt(minutos) > 15 && parseInt(minutos) < 31) {
        minutos = 30;
      } else {
        minutos = 15;
      }
      if (parseInt(hora) > 11) {
        meridiano = "PM";
      }
      if (parseInt(hora) > 12) {
        hora = hora - 12;
      }
      var horaF = hora + 1;
      if (parseInt(hora) < 10) {
        hora = "0" + hora;
      }
      var meridianoF = "AM";
      if (parseInt(horaF) > 11) {
        meridianoF = "PM";
      }
      if (parseInt(horaF) > 12) {
        horaF = horaF - 12;
      }
      if (parseInt(horaF) < 10) {
        horaF = "0" + horaF;
      }
      var data = {
        'start': moment(start._d).format("YYYY-MM-DD"), //moment(start._d).add(1, 'days').format("YYYY-MM-DD"),
        'end': moment(end._d).format("YYYY-MM-DD"),
        'fecha_inicio_hora': hora,
        'fecha_inicio_minutos': minutos,
        'fecha_inicio_am': meridiano,
        'fecha_fin_minutos': minutos,
        'fecha_fin_hora': horaF,
        'fecha_fin_am': meridianoF,
        'id': '-1',
        //'start': moment(start._d).add(1, 'days').format("YYYY-MM-DD"),
//        'start': moment(start._d).format("YYYY-MM-DD"),
//                'end': moment(end._d).format("YYYY-MM-DD"),
      };
      obtenerDialogoActividad(data);
    },
    eventLimit: true, // allow "more" link when too many events
    events: cargarEventos(),
    timeFormat: 'hh:mm A',
    axisFormat: 'hh:mm A'
  });
}

function obtenerDialogoActividad(datos, event) {

  var fechaActual = new Date();
  var year = fechaActual.getFullYear();
  var mes = fechaActual.getMonth() + 1;
  if (parseInt(mes) < 10) {
    mes = "0" + mes;
  }
  var dia = fechaActual.getDate();
  if (parseInt(dia) < 10) {
    dia = "0" + dia;
  }
  var hora = fechaActual.getHours();
  var meridiano = "AM";
  var minutos = fechaActual.getMinutes();
  if (parseInt(minutos) > 45 && parseInt(minutos) < 60) {
    hora += 1;
  } else if (parseInt(minutos) > 30 && parseInt(minutos) < 46) {
    minutos = 45;
  } else if (parseInt(minutos) > 15 && parseInt(minutos) < 31) {
    minutos = 30;
  } else {
    minutos = 15;
  }
  var horaF = hora + 1;
  if (parseInt(hora) > 11) {
    meridiano = "PM";
  }
  if (parseInt(hora) > 12) {
    hora = hora - 12;
  }

  if (parseInt(hora) < 10) {
    hora = "0" + hora;
  }
  meridianoF = "AM";
  if (parseInt(horaF) > 11) {
    meridianoF = "PM";
  }
  if (parseInt(horaF) > 12) {
    horaF = horaF - 12;
  }
  if (parseInt(horaF) < 10) {
    horaF = "0" + horaF;
  }

  if (parseInt(datos.fecha_fin_hora) > 12) {
    datos.fecha_fin_hora = datos.fecha_fin_hora - 12;
    if (parseInt(datos.fecha_fin_hora) < 10) {
      datos.fecha_fin_hora = "0" + datos.fecha_fin_hora;
    }
  }
  if (parseInt(datos.fecha_inicio_hora) > 12) {
    datos.fecha_inicio_hora = datos.fecha_inicio_hora - 12;
    if (parseInt(datos.fecha_inicio_hora) < 10) {
      datos.fecha_inicio_hora = "0" + datos.fecha_inicio_hora;
    }
  }
  if (datos.start !== "") {
    var fechaI = datos.start.split("T");
    datos.start = fechaI[0];
  }
  if (datos.end !== "") {
    var fechaI = datos.end.split("T");
    datos.end = fechaI[0];
  }
  if (datos.duracion === undefined) {
    datos.duracion = "";
  }
  if (datos.lugar === undefined) {
    datos.lugar = "";
  }

  console.log(event);
  var data = {
    'id': (datos.id) ? datos.id : '-1',
    'registroId': $("#registro_id").val(),
    'title': (datos.title) ? datos.title : '',
    'start': (datos.start) ? datos.start : year + '-' + mes + '-' + dia,
    'end': (datos.start) ? datos.end : year + '-' + mes + '-' + dia,
    'fecha_inicio_hora': (datos.fecha_inicio_hora) ? datos.fecha_inicio_hora : hora,
    'fecha_inicio_minutos': (datos.fecha_inicio_minutos) ? datos.fecha_inicio_minutos : minutos,
    'fecha_inicio_am': (datos.fecha_inicio_am) ? datos.fecha_inicio_am : meridiano,
    'fecha_fin_minutos': (datos.fecha_fin_minutos) ? datos.fecha_fin_minutos : minutos,
    'fecha_fin_hora': (datos.fecha_fin_hora) ? datos.fecha_fin_hora : horaF,
    'fecha_fin_am': (datos.fecha_fin_am) ? datos.fecha_fin_am : meridianoF,
    'tipo': (datos.tipo) ? datos.tipo : datos.tipo,
    'relacionado': (datos.relacionado) ? datos.relacionado : datos.relacionado,
    'relacionado_id': (datos.relacionado_id) ? datos.relacionado_id : datos.relacionado_id,
    'estado': (datos.estado) ? datos.estado : datos.estado,
    'aviso': (datos.aviso) ? datos.aviso : datos.aviso,
    'prioridad': (datos.prioridad) ? datos.prioridad : datos.prioridad,
    'contacto': (datos.contacto) ? datos.contacto : datos.contacto,
    'duracion': (datos.duracion) ? datos.duracion : datos.duracion,
    'tipo_llamada': (datos.tipo_llamada) ? datos.tipo_llamada : datos.tipo_llamada,
    'lugar': (datos.lugar) ? datos.lugar : datos.lugar,
    'descripcion': (datos.descripcion) ? datos.descripcion : datos.descripcion,
  };

  bootbox.dialog({
    title: (data.id >= 0) ? s3vars.L_MOD.lbl_editar_actividad : s3vars.L_MOD.lbl_nueva_actividad,
    message: obtenerFormularioActividad(data),
    buttons: {
      success: {
        label: s3vars.L_APP.lbl_boton_guardar,
        className: "btn-primary",
        callback: function () {
          if (validarFormulario_calendario()) {
            $.ajax({
              url: 'index.php?modulo=actividades&accion=editar&ajax=true',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: $('#form_actividades').serialize(),
              success: function (data) {
                console.log(data);
                if (data) {

                  var eventData = {
                    'id': data.id,
                    'title': data.nombre,
                    'start': data.fecha_inicio,
                    'end': data.fecha_fin,
                    'nuevo': data.nuevo,
                  };
                  renderCalendar();
                  if (eventData.nuevo) {
                    $(id_calendario).fullCalendar('renderEvent', eventData, true); // stick? = true
                  } else {
                    event.title = eventData.title;
                    event.start = eventData.start;
                    event.end = eventData.end;
                    $(id_calendario).fullCalendar('updateEvent', event); // stick? = true
                  }
                }
              }
            });
          } else {
            return false;
          }

        }
      }
    }
  });
  $(".datepicker").css("z-index", '10000');
}

function cargarEventos(id, actualizar) {
  var update = '';
  if (id) {
    id = '&id=' + id;
    if (actualizar) {
      update = "&actualizar=true";
      var datos_request = actualizar;
    }
  } else {
    id = '';
  }
  var datos;
  $.ajax({
    url: 'index.php?modulo=actividades&accion=ObtenerActividades' + id + update,
    type: 'POST',
    dataType: 'json',
    data: datos_request,
    async: false,
    success: function (data) {
      datos = data;
      // console.log(datos);
      //console.error(data);
    }
  });
  return datos;
}

function actulizarDataDropStopReSize(event) {

//    console.log(event);
  var fecha_inicio = event.start._d;
  fecha_inicio = fecha_inicio.getUTCFullYear() + "-" + (fecha_inicio.getUTCMonth() + 1) + "-" + fecha_inicio.getUTCDate();
  //+ " " + fecha_inicio.getUTCHours() + ":" + fecha_inicio.getUTCMinutes() + ":" + fecha_inicio.getUTCSeconds();
  var fecha_fin = event.end._d;
  fecha_fin = fecha_fin.getUTCFullYear() + "-" + (fecha_fin.getUTCMonth() + 1) + "-" + fecha_fin.getUTCDate();
  //+ " " + fecha_fin.getUTCHours() + ":" + fecha_fin.getUTCMinutes() + ":" + fecha_fin.getUTCSeconds();
  var datos = {
    'id': event.id,
    'nombre': event.title,
    'fecha_inicio': fecha_inicio,
    'fecha_fin': fecha_fin,
    'hora_inicio': fecha_inicio.getUTCHours() + ":" + fecha_inicio.getUTCMinutes() + ':00',
    'hora_fin': fecha_fin.getUTCHours() + ":" + fecha_fin.getUTCMinutes() + ':00',
    'tipo': event.tipo,
    'relacionado': event.relacionado,
    'relacionado_id': event.relacionado_id,
    'estado': event.estado,
    'aviso': event.aviso,
    'prioridad': event.prioridad,
    'contacto': event.contacto,
    'duracion': event.duracion,
    'tipo_llamada': event.tipo_llamada,
    'lugar': event.lugar,
    'descripcion': event.descripcion,
  };
  return datos;
}

$(document).ready(function () {

  bootbox.setDefaults({
    locale: "es"
  });
  renderCalendar();
}
);
window.onload = function(){ campos_tipo(); }
function campos_tipo() {
    op = $("#tipo_actividad").val();
    console.log(op);
    if (op == 38) { // tarea

        $(".panel-tarea").show();
        $(".panel-tarea").find('input,select').removeAttr('disabled');
        $(".panel-tarea").find('.addreq').addClass('required');
        $(".panel-tarea").find('.addreq').addClass('required');
        $(".panel-llamada").find('.addreq').removeClass('required');
        $(".panel-llamada").find('.addreq').removeClass('required');
        $(".panel-llamada").find('input').removeClass('required');
        $(".panel-reunion").find('input').removeClass('required');



        $(".panel-llamada").hide();
        $(".panel-reunion").hide();
        $(".panel-llamada").find('input,select').attr('disabled', 'disabled');
        $(".panel-reunion").find('input,select').attr('disabled', 'disabled');
    }
    if (op == 39) {
        $(".panel-llamada").show();
        $(".panel-llamada").find('input,select').removeAttr('disabled');
        $(".panel-llamada").find('.addreq').addClass('required');
        $(".panel-tarea").find('.addreq').removeClass('required');
        $(".panel-reunion").find('.addreq').removeClass('required');
        $(".panel-tarea").hide();
        $(".panel-reunion").hide();
        $(".panel-tarea").find('input,select').attr('disabled', 'disabled');
        $(".panel-reunion").find('input,select').attr('disabled', 'disabled');
    }
    if (op == 40) {
        $(".panel-reunion").show();
        $(".panel-reunion").find('input,select').removeAttr('disabled');
        $(".panel-reunion").find('.addreq').addClass('required');
        $(".panel-llamada").find('.addreq').removeClass('required');
        $(".panel-tarea").find('.addreq').removeClass('required');
        $(".panel-llamada").hide();
        $(".panel-tarea").hide();
        $(".panel-llamada").find('input,select').attr('disabled', 'disabled');
        $(".panel-tarea").find('input,select').attr('disabled', 'disabled');
    }
}





/*
 * 
 * sfadsfasdfadsfads
 */

$(document).ready(function () {

  triggersInvitado_act();
});

/*
// CARGAR UN NUEVO INVITADO
function agregarInvitado_act() {

  option_cuenta = '';

//var html = '<div class="form-group col-sm--12">' +
//            '<input type="hidden" class="id" name="item_meta_id[]" value="">' +
//            '<input type="hidden" class="eliminado" name="meta_eliminado[]" value="0">' +

  var html = '<div  class="col-sm-12 form-group">' +
          '<input type="hidden" class="eliminado" name="invitado_eliminado[]" value="0">' +
          '<input class="id" type="hidden" id="id_invitado" name="id_invitado[]" >' +
          '<div class=" col-sm-2">' +
          '<select class="form-control required" id="modulo_actividad" name="modulo_actividad[]" onchange="t_modulo_actividad_act(this)">' +
          '<option value="-1">Seleccionar</option>' +
          '<option value="1">Clientes</option>' +
          '<option value="2">Contactos</option>' +
          '<option value="3">Usuarios</option>' +
          '</select>' +
          '</div>' +
          '<div class=" col-sm-5">' +
          '<select class="form-control required" id="nombre_actividad" name="nombre_actividad[]" onchange="obtener_email_actividad(this)">' +
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
}*/

function t_modulo_actividad_act(obj) {
//define la lista de cliente o de usuarios

  option = '';
  option = '<option value="-1">Seleccionar</option>';
  if ($(obj).val() == '1') {
    for (i = 0; i < s3vars.cuentas_calendario.length; i++) {
      option += '<option value="' + s3vars.cuentas_calendario[i]['id'] + '">' + s3vars.cuentas_calendario[i]['nombre'] + '</option>';
    }
  }
  if ($(obj).val() == '2') {
    for (i = 0; i < s3vars.contactos_calendario.length; i++) {
      option += '<option value="' + s3vars.contactos_calendario[i]['id'] + '">' + s3vars.contactos_calendario[i]['nombre'] + '</option>';
    }
  }
  if ($(obj).val() == '3') {
    for (i = 0; i < s3vars.usuarios_calendario.length; i++) {
      option += '<option value="' + s3vars.usuarios_calendario[i]['id'] + '">' + s3vars.usuarios_calendario[i]['nombre'] + '</option>';
    }
  }

  $($(obj).parent().parent()[0]['children'][3]['children'][0]).html('');
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


// CARGA INVITADOS YA RELACINADOS
function cargar_invitados_cal(id) {
  var invitados = '';
  $.ajax({
    type: "POST",
    url: 'index.php?modulo=actividades&accion=obtenerinvitados',
    data: 'id=' + id,
    dataType: "json",
    async: false,
//        processData: false,
//        contentType: false
  }).done(function (result) {
//        console.log(result);
    invitados = result;
  });

  div = '';
  for (i = 0; i < invitados.length; i++) {

    op_m = '';
    op = '';
    if (invitados[i]['modulo_actividad'] == 1) {
      op_m = '<option value="1" selected>clientes</option><option value="2">usuarios</option>';
      for (key in s3vars.clientes_calendario) {
        op += "<option value='" + s3vars.clientes_calendario[key]['id'] + "'";
        if (invitados[i]['nombre_actividad'] == s3vars.clientes_calendario[key]['id']) {
          op += "selected";
        }
        op += ">" + s3vars.clientes_calendario[key]['nombre'] + "</option>";
      }

    }
    if (invitados[i]['modulo_actividad'] == 2) {
      op_m = '<option value="1">clientes</option><option value="2" selected>usuarios</option>';

      for (key in s3vars.usuarios_calendario) {
        op += "<option value='" + s3vars.usuarios_calendario[key]['id'] + "'";
//                op += "<option value='" + key + "'";
        if (invitados[i]['nombre_actividad'] == s3vars.usuarios_calendario[key]['id']) {
          op += "selected";
        }
        op += ">" + s3vars.usuarios_calendario[key]['nombre'] + "</option>";
      }
    }
    div += '<div  class="col-sm-12 form-group">' +
            '<input type="hidden" class="eliminado" name="invitado_eliminado[]" value="0">' +
            '<input class="id" type="hidden" id="id_invitado" name="id_invitado[]" value="' + invitados[i]['id'] + '">' +
            '<div class=" col-sm-2">' +
            '<select class="form-control required" id="modulo_actividad" name="modulo_actividad[]" onchange="t_modulo_actividad_act(this)">' +
            '<option value="-1">Seleccionar</option>' +
            op_m +
            '</select>' +
            '</div>' +
            '<div class=" col-sm-5">' +
            '<select class="form-control required" id="nombre_actividad" name="nombre_actividad[]" onchange="obtener_email_actividad(this)">' +
            '<option value="-1">Seleccionar</option>' +
            op +
            '</select>' +
            '</div>' +
            '<div class="col-sm-4 ">' +
            '<input class="form-control required" type="email" id="email_actividad"  name="email_actividad[]" value="' + invitados[i]['email_actividad'] + '">' +
            '</div>' +
            '<div class="col-sm-1 ">' +
//                '<button type="button" onclick="del_invitado(this);" class="btn btn_eliminar_reg_invitado_act btn-primary btn-xs"><i class="fa fa-minus"></i></button> ' +
            '<button type="button"  class="btn btn_eliminar_reg_invitado_act btn-primary btn-xs"><i class="fa fa-minus"></i></button> ' +
            '</div>' +
            '</div>';
  }
  return div;
}

function campos_tipo_calendario() {
  op = $("#tipo").val();
  console.log(op);
  if (op == 38) { // Tarea

    $(".panel-tarea").show();
    $(".panel-tarea").find('input,select').removeAttr('disabled');
    $(".panel-tarea").find('.addreq').addClass('required');
    $(".panel-tarea").find('.addreq').addClass('required');
    $(".panel-llamada").find('.addreq').removeClass('required');
    $(".panel-llamada").find('.addreq').removeClass('required');
    $(".panel-llamada").find('input').removeClass('required');
    $(".panel-reunion").find('input').removeClass('required');
    $(".panel-llamada").hide();
    $(".panel-reunion").hide();
    $(".panel-llamada").find('input,select').attr('disabled', 'disabled');
    $(".panel-reunion").find('input,select').attr('disabled', 'disabled');
  }
  if (op == 39) { // Llamada

    $(".panel-llamada").show();
    $(".panel-llamada").find('input,select').removeAttr('disabled');
    $(".panel-llamada").find('.addreq').addClass('required');
    $(".panel-tarea").find('.addreq').removeClass('required');
    $(".panel-reunion").find('.addreq').removeClass('required');
    $(".panel-tarea").hide();
    $(".panel-reunion").hide();
    $(".panel-tarea").find('input,select').attr('disabled', 'disabled');
    $(".panel-reunion").find('input,select').attr('disabled', 'disabled');
  }
  if (op == 40) { // Reunión
    $(".panel-reunion").show();
    $(".panel-reunion").find('input,select').removeAttr('disabled');
    $(".panel-reunion").find('.addreq').addClass('required');
    $(".panel-llamada").find('.addreq').removeClass('required');
    $(".panel-tarea").find('.addreq').removeClass('required');
    $(".panel-llamada").hide();
    $(".panel-tarea").hide();
    $(".panel-llamada").find('input,select').attr('disabled', 'disabled');
    $(".panel-tarea").find('input,select').attr('disabled', 'disabled');
  }
}