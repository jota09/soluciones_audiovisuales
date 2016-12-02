$(document).ready(function() {

$('#filtroFechaCierre21').datepicker().on('changeDate', function (ev) {
    console.log($('#filtroFechaCierre21').val())
});

    $("#filtroAsignado").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroLinea").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroEtapa").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $('#filtroFechaCierre21').datepicker().on('changeDate', function (ev) {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroNumeroFactura").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroOportunidad").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $("#filtroCuenta").click(function() {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    $('#filtroFechaFactura22').datepicker().on('changeDate', function (ev) {
        $('#tabla_listar').DataTable().ajax.reload();
    });
    

});
