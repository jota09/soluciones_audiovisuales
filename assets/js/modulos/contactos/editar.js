$(document).ready(function () {
  $('#form_editar').validationEngine();
  $('#cuenta_id').select2('readonly', false);

  var div = $('#view_ubicacion_id');
  autocompletarUbicacion(div);

  $('#fecha_nacimiento').each(function (kf, vf) {
    var dp = $(vf).datepicker({
      format: 'dd-mm-yyyy'
    }).on('changeDate', function (ev) {
      var fecha = new Date(ev.date);
      var hoy = new Date();

      var anno = fecha.getFullYear();
      var mes = fecha.getMonth();
      var dia = fecha.getDate();

      var edad = hoy.getFullYear() - anno - 1;

      if (mes < hoy.getMonth()) {
        edad++;
      } else if (mes == hoy.getMonth()) {
        if (hoy.getDate() - dia >= 0) {
          edad++;
        }
      }

      $('#fecha_nacimiento_span').html(edad + ' A&ntilde;os');
      $('#edad').val(edad);
      dp.hide();
    }).data('datepicker');
  });

  $('#fecha_nacimiento').keyup(function () {
    var fecha = new Date($(this).val());
    var hoy = new Date();

    var anno = fecha.getFullYear();
    var mes = fecha.getMonth();
    var dia = fecha.getDate();

    var edad = hoy.getFullYear() - anno - 1;

    if (mes < hoy.getMonth()) {
      edad++;
    } else if (mes == hoy.getMonth()) {
      if (hoy.getDate() - dia >= 0) {
        edad++;
      }
    }

    $('#fecha_nacimiento_span').html(edad + ' A&ntilde;os');
    $('#edad').val(edad);
  });
  //cargarEdad();
  $("#cuenta_id").change(function () {
    buscaInformaA($("#cuenta_id").val());
  });

  if (s3vars.registro.id > 0) {
    buscaInformaA($("#cuenta_id").val());
  }

  agregarInvitado_act();
});

function cargarEdad() {
  var fecha = ($('#fecha_nacimiento').val().toString()).split('-');
  var hoy = new Date();

  var anno = parseInt(fecha[0]);
  var mes = parseInt(fecha[1]);
  var dia = parseInt(fecha[2]);

  var edad = hoy.getFullYear() - anno - 1;

  if (hoy.getMonth() > (mes - 1)) {
    edad++;
  } else if ((mes - 1) == hoy.getMonth()) {
    if (hoy.getDate() - dia >= 0) {
      edad++;
    }
  }

  $('#fecha_nacimiento_span').html(edad + ' A&ntilde;os');
  $('#edad').val(edad);
  return edad;
}

function cambioTipoDocumento(myArray) {

  if (!s3vars.registro.tipo_documento_id) {
    $("#tipo_documento_id").select2("val", '-1');
  }

  $('#tipo_documento_id option').each(function (k, v) {
    $(v).removeAttr('disabled');
    if (myArray.indexOf($(v).val()) >= 0) {
      $(v).attr('disabled', 'disabled');
    }
  });
  s3vars.registro.tipo_documento_id = null;
}

function buscaInformaA(cuenta) {
  $.ajax({
    type: "POST",
    url: 'index.php?modulo=contactos&accion=ObtenerInformaA',
    data: 'cuenta_id=' + cuenta,
    dataType: "json",
  }).done(function (result) {
    console.log(result);
    $("#informa_a_id option").remove();
    var html = '';
    $.each(result, function (k, v) {
      if (s3vars.registro.id !== v.id) {

        html += '<option value="' + v.id + '" > ' + v.nombres + ' </option>';
      }
    });

    $("#informa_a_id").append(html);
    $("#informa_a_id").select2("val", s3vars.registro.informa_a_id);
    if (parseInt(s3vars.registro.informa_a_id) > 0) {
      $(".imforma_a").html('<a target="_blank" class="form" href="index.php?modulo=contactos&accion=editar&registro=' + $("#informa_a_id").val() + '" >' + $("#informa_a_id").text() + '</a>');
    }

  });
}
