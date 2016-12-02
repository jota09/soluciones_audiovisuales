var tbl_act;
var tbl_opp;
$(document).ready(function () {
   
    tbl_act = $('#mis_actividades').dataTable({
      "ordering": false,
      "processing": true,
      "ajax": {
         "url": "index.php?modulo=actividades&accion=filtrarActividades",
         "type": "POST",
         "data": function (d) {
            d.referencia = $("#filtro_referencia").val();
            d.tipo = $("#filtro_tipo").val();
            d.fecha_desde = $("#filtro_fecha_desde").val();
            d.fecha_hasta = $("#filtro_fecha_hasta").val();
         }
      },
      "columns": [
         {data: "nombre"}, {data: "tipo"},{data: "fecha_fin", className: "text-center"}, {data: "vacio"}
      ],
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
         //console.log(nRow);
      }
   });

   tbl_opp = $('#mis_oportunidades').dataTable({
      "ordering": false,
      "processing": true,
      "ajax": {
         "url": "index.php?modulo=oportunidades&accion=filtrarOportunidades",
         "type": "POST",
         "data": function (d) {
            d.referencia = $("#filtro_referencia").val();
            d.asignado = $("#filtro_asignado").val();
            d.etapa = $("#filtro_etapa").val();
            
         }
      },
      "columns": [
         {data: "nombre"}, {data: "valor", className: "text-right"},
         {data: "etapa"}, {data: "asignado"},  {data: "vacio"}
      ],
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

      }
   });
   
   $("#limpiar_actividad").click(function () {
      $("#filtro_actividad input").val("");
      $("#filtro_actividad select").val(null).trigger("change");
   });

   $("#limpiar_oportunidad").click(function () {
      $("#filtro_oportunidad input").val("");
      $("#filtro_oportunidad select").val(null).trigger("change");
   });
   
    $('select').each(function (i, o) {
      $(o).select2();
   });
});


function filtrarActividades() {

   $("#filtrar_actividad_esperar").removeClass("hidden");
   $('#mis_actividades').DataTable().ajax.reload();
   $("#filtrar_actividad_esperar").addClass("hidden");
   $('#filtro_actividad').modal('hide');

}

function filtrarOportunidades() {

   $("#filtrar_oportunidad_esperar").removeClass("hidden");
   $('#mis_oportunidades').DataTable().ajax.reload();
   $("#filtrar_oportunidad_esperar").addClass("hidden");
   $('#filtro_oportunidad').modal('hide');

}

