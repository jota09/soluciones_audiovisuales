window.onload = function(){
   $("#contrasenia").val('');
}
function validarFormulario() {
  if (validar_datos('#form_editar', '#contrasenia', '#contrasenia2')) {
    return true;
  } else {
    alert('Algunos datos no son validos, por favor verifique he intente nuevamente.');
    return false;
  }
}
$(document).ready(function () {
    $('#contrasenia').keyup(function () {
    if ($(this).val() != '') {
      $('#contrasenia2').removeAttr('readonly');
      if (!$('#contrasenia2').hasClass('required')) {
        $('#contrasenia2').addClass('required');
      }
    } else {
      $('#contrasenia2').attr('readonly', 'readonly').removeClass('required');
    }
  });

  $('#perfil_id').change(function () {
        if ($(this).val() == 2) {
            $('#cliente_id').removeAttr('disabled');
            $('#cliente_id').addClass('required');
        } else {
            $('#cliente_id').select2("enable", false);
            $('#cliente_id').removeClass('required');
        }
    });
    $('#form_editar').validationEngine();
});