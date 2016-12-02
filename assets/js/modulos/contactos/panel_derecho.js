$(document).ready(function () {

    //console.log('sfddsf');
   $('#form_asig_oportu').submit(function () {
     
      crear_contact_opp();
      return $('#form_asig_oportu').validationEngine('validate');
   });
   //    $('#nueva_oportunidad #cuenta_id').select2('readonly', true);

  cargar_actividades();
  cargar_documentos();
  cargar_oportunidades();
  $('#form_actividad #fecha_inicio_actividad').datepicker().on('changeDate', function (ev) {
          return $('#form_actividad #fecha_inicio_actividad').validationEngine('validate');
   });
   $('#form_actividad #fecha_fin_actividad').datepicker().on('changeDate', function (ev) {
          return $('#form_actividad #fecha_fin_actividad').validationEngine('validate');
   });
});

