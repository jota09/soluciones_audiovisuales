$(document).ready(function () {
  $('#cuenta_id').select2('readonly', false);

  if (typeof $("#tablaActividades").html() === "string") {
    $("#tablaActividades").dataTable();
  }
  agregarInvitado_act();
  
});

function obtenerDialogoActividad(datos, event) {
  var fechaActual = new Date();
  //console.log('?' + fechaActual.getFullYear() + '-' + (fechaActual.getMonth() + 1) + '-' + fechaActual.getDate());
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
  if (parseInt(minutos) > 45 && parseInt(minutos) < 59) {
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
    'id': (datos.id) ? datos.id : '',
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
  };
  console.log(data);

  bootbox.dialog({
    title: 'Nueva Actividad',
    message: obtenerFormularioActividad(data),
    buttons: {
      success: {
        label: s3vars.L_APP.lbl_boton_guardar,
        className: "btn-warning",
        callback: function () {
          $.ajax({
            url: 'index.php?modulo=casos&accion=guardarActividad&ajax=true',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: $('#form_actividades').serialize(),
            success: function (data) {
              console.log(data);
              fila = "<tr>" +
                      "<td>" + data.nombre + "</td>" +
                      "<td>" + data.fecha_inicio + "</td>" +
                      "<td>" + data.fecha_inicio_hora + ":" + data.fecha_inicio_minutos + ":00 " + data.fecha_inicio_am + "</td>" +
                      "<td>" + data.fecha_fin + "</td>" +
                      "<td>" + data.fecha_fin_hora + ":" + data.fecha_fin_minutos + ":00 " + data.fecha_fin_am + "</td>" +
                      "</tr>";
              $("#tablaActividades").append(fila);
            }
          });
        }
      }
    }
  });
  $(".datepicker").css("z-index", '10000');
}

