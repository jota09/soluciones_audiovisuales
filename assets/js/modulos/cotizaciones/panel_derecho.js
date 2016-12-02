$(document).ready(function () {

   $('#form_cot').submit(function () {
     
      crear_cotizacion();
      return $('#form_cot').validationEngine('validate');
   });
  cargar_documentos();

});

