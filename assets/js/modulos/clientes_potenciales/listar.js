var tablaListar = null;

function crearTablaLista() {
   var columnas = [{"data": "checkbox"}];

   $.each(s3vars.campos, function (a, v) {
      if (v != 'eliminado' && v != 'alterdelact') {
         columnas.push({"data": v});
      }
   });

   if (!jQuery.isEmptyObject(s3vars._filtros)) {
      $.each(s3vars._filtros, function (k, v) {
         if (v.tipo == 'txt') {
            $("#f_" + k).keyup(function () {
               $('#tabla_listar').DataTable().ajax.reload();
            });
         } else if (v.tipo == 'fecha') {
            $("#f_" + k).datepicker().on('changeDate', function (ev) {
               $('#tabla_listar').DataTable().ajax.reload();
            });
         } else {
            $("#f_" + k).click(function () {
               $('#tabla_listar').DataTable().ajax.reload();
            });
         }
      });
   }

   tablaListar = $('#tabla_listar').dataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "ajax": {
         "url": "index.php?modulo=" + s3vars.modulo + "&accion=ajaxtabla",
         "type": "GET",
         "data": function (d) {
            if (!jQuery.isEmptyObject(s3vars._filtros)) {
               d._filtros = {};
               $.each(s3vars._filtros, function (k, v) {
                  if (v.tipo == 'relacionado' || v.tipo == 'relacionado_mul') {
                     d._filtros['_rel_' + k] = $('#f_' + k).val();
                  } else {
                     d._filtros[k] = $('#f_' + k).val();
                  }
               });
            }
            d._filtros.f_15 = $('#f_15').val();
         }
      },
      "columns": columnas,
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
         $(nRow).click(function () {
            if (typeof aData.alterdelact === "undefined" || aData.alterdelact == "1") {
               $.each($(nRow).find('td'), function (a, b) {
                  if (a > 0) {
                     $(b).click(function () {
                        location.href = "index.php?modulo=" + s3vars.modulo + "&accion=editar&registro=" + aData.id;
                     });
                  }
               });
            }
         });
      }
   });

   //tablaListar.ajax.reload();
}

$(document).ready(function () {
   crearTablaLista();

   $('#btn_crear_nuevo').click(function () {
      var modulo = $(this).attr("data-modulo");
      location.href = "index.php?modulo=" + modulo + "&accion=editar";
   });

   $('#form_listar').submit(function () {
      return confirm('Esta seguro que desea continuar con la accion?');
   });

   $('#btn_filtros').click(function () {
      if ($('.filtro').hasClass('hide')) {
         $('.filtro').removeClass('hide');
      } else {
         $('.filtro').addClass('hide');
      }
   });
   $('#btn_clear_filtros').click(function () {
//        $('.input-filtro, .date-range').val('');
//        table.search('').draw();
//        table.columns().search('').draw();
      $("select option:selected").removeAttr("selected");
      $("input").val("");
      $('select').select2("val", "");
      $('#tabla_listar').DataTable().ajax.reload();
   });
   $('select').each(function (i, o) {
      console.log(o);
      $(o).select2();
   });
   
   //Custom filter
   $("#f_15").keyup(function () {
      $('#tabla_listar').DataTable().ajax.reload();
   });
});

