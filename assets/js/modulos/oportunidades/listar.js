$(document).ready(function() {

    $("#filtroCuenta").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroEtapa").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroAsignado").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroTomaContacto").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });

//    $("#btn_clear_filtros").click(function() {
//
//        $("#filtroModulo option:selected").removeAttr("selected");
//        $('#tabla_listar').DataTable().ajax.reload();
//    });


});
