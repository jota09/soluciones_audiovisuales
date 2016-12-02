$(document).ready(function () {
       $('#nuevo_contacto #asesor_id').select2('readonly', true);
       $('#nuevo_contacto #cuenta_id').select2('readonly', true);

   $('#form_asig_contac').submit(function () {
     
      crear_opp_contact();
      return $('#form_asig_contac').validationEngine('validate');
   });

  cargar_actividades();
  cargar_documentos();
  cargar_contactos();
  cargar_cotizaciones();
$('#form_actividad #fecha_inicio_actividad').datepicker().on('changeDate', function (ev) {
          return $('#form_actividad #fecha_inicio_actividad').validationEngine('validate');
   });
   $('#form_actividad #fecha_fin_actividad').datepicker().on('changeDate', function (ev) {
          return $('#form_actividad #fecha_fin_actividad').validationEngine('validate');
   });
});

