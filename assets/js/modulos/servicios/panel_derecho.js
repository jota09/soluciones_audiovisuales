$(document).ready(function () {

  cargar_actividades();
  cargar_documentos();
  cargar_casos();

$('#form_actividad #fecha_inicio_actividad').datepicker().on('changeDate', function (ev) {
          return $('#form_actividad #fecha_inicio_actividad').validationEngine('validate');
   });
   $('#form_actividad #fecha_fin_actividad').datepicker().on('changeDate', function (ev) {
          return $('#form_actividad #fecha_fin_actividad').validationEngine('validate');
   });
});
