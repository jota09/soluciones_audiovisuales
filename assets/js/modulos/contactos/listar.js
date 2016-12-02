$(document).ready(function() {

    $("#filtroEstado").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroAsignado").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroCuenta").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroCargo").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });

//    $("#btn_clear_filtros").click(function() {
//
//        $("#filtroModulo option:selected").removeAttr("selected");
//        $('#tabla_listar').DataTable().ajax.reload();
//    });


});
