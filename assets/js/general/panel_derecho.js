var fila = 1;
var editor = "";

function agregarNuevoDetalleCotizacion() {
    fila++;
    var html = '<div class="form-group col-sm-12 no-padding-right"> ' +
            '<input type="hidden" class="id" name="detalle_cotizacion_id[]" value="">' +
            '<input type="hidden" name="detalle_producto_id[]" id="detalle_producto_id_' + fila + '" value="">' +
            '<input type="hidden" class="eliminado" name="detalle_cotizacion_eliminado[]" value="0">' +
            '<div class="col-sm-1 no-padding-right">' +
            '<input type="text" class="form-control validate[required]" value="1" id="detalle_cantidad_' + fila + '" name="detalle_cantidad[]" onkeyup="calcularTotal(); return soloNumeros(event); " > </div> ' +
            '<div class="col-sm-2 no-padding-right"> ' +
            '<input type="text" class="form-control " value="" id="detalle_categoria_' + fila + '" name="detalle_categoria[]" readonly="readonly" ></div> ' +
            '<div class="col-sm-2 no-padding-right"> ' +
            '<input type="text" class="form-control " value="" id="detalle_referencia_' + fila + '" name="detalle_referencia[]" onkeyup="buscarProducto(this);"  ></div> ' +
            '<div class="col-sm-2 no-padding-right"> ' +
            '<textarea class="form-control" name="detalle_descripcion[]" id="detalle_descripcion_' + fila + '" rows="2" readonly="readonly"></textarea></div> ' +
            '<div class="col-sm-2 no-padding-right"> ' +
            '<input type="text" class="form-control validate[required] text-right number" value="" id="detalle_valor_unitario_' + fila + '" name="detalle_valor_unitario[]"  ></div> ' +
            '<div class="col-sm-2 no-padding-right"> ' +
            '<input type="text" class="form-control validate[required] text-right number" id="detalle_total_' + fila + '"  readonly="readonly" value="" name="detalle_total[]"  ></div> ' +
            '<div class="col-sm-1 no-padding-right"> ' +
            '<button type="button" class="btn btn_eliminar_reg_detalle_cotizacion btn-default center-block btn-sm"><i class="fa fa-minus"></i></button> </div> ' +
            '</div>';

    $('#detalle_cotizacion').append(html);
    $('.number').number(true, 0, '.', ',');
    triggersDetalle_cotizacion();
}

function eliminarCampoRegistroDetalleCotizacion(div) {
    if ($(div).find('.id').val() > 0 && $(div).find('.id').val() != "" && $(div).find('.id').val() != "0") {
        $(div).find('.eliminado').val(1);
        $(div).addClass('hidden');
    } else {
        $(div).remove();
    }
}


function triggersDetalle_cotizacion() {
    $('.btn_eliminar_reg_detalle_cotizacion').click(function () {
        eliminarCampoRegistroDetalleCotizacion($(this).parent().parent());
    });
    if (s3vars.modulo != 'calendario') {
        if (s3vars.registro.linea_id == 74) {
            $('input[name^="detalle_valor_unitario"]').attr('readonly', 'readonly');
        }
    }

}

function buscaOportunidadesXCuenta(cuenta) {
    $("#load-buscar-general").removeClass('hidden');
    $.ajax({
        type: "POST",
        url: 'index.php?modulo=oportunidades&accion=OportunidadXCuenta',
        data: {modulo_id: cuenta, modulo_name: 'cuentas'},
        dataType: "json",
    }).done(function (result) {

        $("#oportunidad_id option").remove();
        var html = '';
        $.each(result, function (k, v) {
            html += '<option value="' + v.id + '" > ' + v.referencia + ' </option>';

        });

        $("#oportunidad_id").append(html);
        $("#load-buscar-general").addClass('hidden');

    });
}


function buscarProducto(obj) {

    if (s3vars.modulo != 'cotizaciones') {
        var y = $("#nueva_cotizacion #fecha_cierre").val()
    } else {
        var y = $("#fecha_cierre").val()
    }
    $(obj).autocomplete({
        minLength: 1,
        source: function (request, response) {
            $.ajax({
                url: "index.php",
                dataType: "json",
                async: true,
                method: 'GET',
                data: {
                    'modulo': 'productos',
                    'accion': 'ObtenerProductosXNombre',
                    'nombre': request.term,
                    'cotizacion': true,
                    'fecha_cotizacion': y,
                    'cuenta': $("#cuenta_id").val()
                },
                beforeSend: function () {
                    $('#load-buscar-general').removeClass('hidden');
                    $('#btn_agregar').attr('disabled', 'disabled');
                },
                success: function (data) {

                    $('#load-buscar-general').addClass('hidden');
                    response(data);
                },
                error: function (err) {
                    console.log('err' + err);
                }
            }).done(function (done) {

                if (done.length == 0) {
                    $('#btn_agregar').removeAttr('disabled');
                }
                if (done.length == 0 && s3vars.accion == "editar" && s3vars.registro == "") {

                } else if (done.length == 0 && s3vars.accion == "editar" && s3vars.registro != "") {
                    console.log("NO nuevo");
                }

            }).fail(function (fail) {
                console.log('fail' + fail);
            });
        },
        select: function (event, ui) {
            myVar = setInterval(function () {
                cargarProductoSeleccionado(ui.item, $(obj));
            }, 500);
            //location.href = 'index.php?modulo=' + ui.item.modulo + '&accion=' + ui.item.accion + '&' + ui.item.variable_nombre + '=' + ui.item.variable_valor;
        }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {

        //$('#load-buscar-general').addClass('hidden');
        return $("<li>").append("<a >" + item.referencia + "</a>").appendTo(ul);

    };

}

function cargarProductoSeleccionado(reg, obj) {

    var aux = obj.attr('id').split("_");
    console.log(reg);

    $("#detalle_codigo_" + aux[2]).val(reg.codigo);
    $("#detalle_producto_id_" + aux[2]).val(reg.producto_id);
    $("#detalle_categoria_" + aux[2]).val(reg.categoria);
    $("#" + obj.attr('id')).val(reg.referencia);
    $("#detalle_descripcion_" + aux[2]).val(reg.descripcion);
    $("#detalle_valor_unitario_" + aux[2]).val(reg.precio);

    calcularTotal();

    clearInterval(myVar);

}
function calcularTotal() {

    var porcentaje_id = $("#iva").val();
    if (s3vars.modulo != 'cotizaciones' && s3vars.modulo != 'cuentas') {
        $.each(s3vars.listasM2.iva, function (k, v) {
            if (v.id == porcentaje_id) {
                porcentaje_iva = parseInt(v.nombre);
            }
        });
    }
    if (s3vars.modulo == 'cuentas') {
        $.each(s3vars.listasM3.iva, function (k, v) {
            if (v.id == porcentaje_id) {
                porcentaje_iva = parseInt(v.nombre);
            }
        });
    }
    if (s3vars.modulo == 'cotizaciones') {
        $.each(s3vars.listasM.iva, function (k, v) {
            if (v.id == porcentaje_id) {
                porcentaje_iva = parseInt(v.nombre);
            }
        });
    }
    var subtotal = 0;
    for (var i = 1; i <= fila; i++) {

        if ($("#detalle_cantidad_" + i).val() !== undefined) {
            var total = parseInt($("#detalle_cantidad_" + i).val() * $("#detalle_valor_unitario_" + i).val());
            $("#detalle_total_" + i).val(total);
            subtotal += total;
        }
    }

    var descuento = parseInt($("#descuento").val());
    var subtotal_descuento = subtotal - descuento;
    var iva = subtotal_descuento * (parseInt(porcentaje_iva) / 100);
    var total_total = subtotal_descuento + iva;

    $("#subtotal").val(subtotal);
    $("#subtotal_descuento").val(subtotal_descuento);
    $("#valor_iva").val(iva);
    $("#total").val(total_total);
    return true;
}

function agregarDetalleCotizacion() {

    $.each(s3vars.detalles, function (kk, vv) {
        console.log(vv);

        var html = '<div class="form-group col-sm-12 no-padding-right"> ' +
                '<input type="hidden" class="id" name="detalle_cotizacion_id[]" value="' + vv.id + '">' +
                '<input type="hidden" name="detalle_producto_id[]" id="detalle_producto_id_' + fila + '"  value="' + vv.producto_id + '">' +
                '<input type="hidden" class="eliminado" name="detalle_cotizacion_eliminado[]" value="0">' +
                '<div class="col-sm-1 no-padding-right editar_js">' +
                '<input type="text" class="form-control validate[required]"  value="' + vv.cantidad + '" id="detalle_cantidad_' + fila + '" name="detalle_cantidad[]"  onkeyup="calcularTotal(); return soloNumeros(event); " > </div> ' +
                '<label class="control-label col-sm-1 ver_js" >' + vv.cantidad + '</label>' +
                '<div class="col-sm-2 no-padding-right editar_js"> ' +
                '<input type="text" class="form-control "  value="' + vv.categoria + '" id="detalle_categoria_' + fila + '" name="detalle_categoria[]" readonly="readonly" ></div> ' +
                '<label class="control-label col-sm-2 ver_js" >' + vv.categoria + '</label>' +
                '<div class="col-sm-2 no-padding-right editar_js"> ' +
                '<input type="text" class="form-control "  value="' + vv.referencia + '" id="detalle_referencia_' + fila + '" name="detalle_referencia[]" onkeyup="buscarProducto(this);"  ></div> ' +
                '<label class="control-label col-sm-2 ver_js" >' + vv.referencia + '</label>' +
                '<div class="col-sm-2 no-padding-right editar_js"> ' +
                '<textarea class="form-control" name="detalle_descripcion[]" id="detalle_descripcion_' + fila + '" rows="2" readonly="readonly">' + vv.descripcion + '</textarea></div> ' +
                '<label class="control-label col-sm-2 ver_js" >' + vv.descripcion + '</label>' +
                '<div class="col-sm-2 no-padding-right editar_js"> ' +
                '<input type="text" class="form-control validate[required] text-right number"  value="' + vv.valor_unitario + '" id="detalle_valor_unitario_' + fila + '" name="detalle_valor_unitario[]"  onkeyup="calcularTotal(); return soloNumeros(event); " ></div> ' +
                '<label class="control-label col-sm-2 ver_js" >' + vv.valor_unitario + '</label>' +
                '<div class="col-sm-2 no-padding-right editar_js"> ' +
                '<input type="text" class="form-control validate[required] text-right number" id="detalle_total_' + fila + '"  value="' + vv.valor_unitario * vv.cantidad + '" name="detalle_total[]"  onkeypress="return soloNumeros(event);" ></div> ' +
                '<label class="control-label col-sm-2 ver_js" style="text-align:right;">' + vv.detalle_total + '</label>' +
                '<div class="col-sm-1 no-padding-right editar_js"> ' +
                '<button type="button" class="btn btn_eliminar_reg_detalle_cotizacion btn-default center-block btn-sm"><i class="fa fa-minus"></i></button> </div> ' +
                '</div>';

        $('#detalle_cotizacion').append(html);
        triggersDetalle_cotizacion();

        $(".editar_js").css({display: "none"});
        $('.number').number(true, 0, '.', ',');
        fila++;
    });

    calcularTotal();
}

function enviarCotizacionCorreo() {
    $("#add_msg").html("").html("Enviando correo");
    $('#Esperar').modal('show');
    $.ajax({
        type: "POST",
        url: 'index.php?modulo=cotizaciones&accion=enviarCotizacion',
        data: {registro_id: s3vars.registro.id, cuenta_id: $("#cuenta_id").val(), detalle_correo: editor.getData(), remitentes: $('#remitentes').val().join(',')},
        dataType: "json",
    }).done(function (result) {
        $('#remitentes').select2('val', '');
        editor.setData("");
        $('#Esperar').modal('hide');
        $('#enviar_correo').modal('hide');

        if (result != '') {
            bootbox.alert("Se ha enviado la cotización a las siguientes direcciones de correo: <b>" + result + "</b>");
        }

    });
}

function cargarEditor() {
    editor = CKEDITOR.replace('enviar_detalle_correo', {
        toolbar: [
            //['Source','-','Save','NewPage','Preview','-','Templates'],
            //['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
            //['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
            //['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
            //'/',
            ['Bold', 'Italic', 'Underline', 'Strike'], //,'-','Subscript','Superscript'
            ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote'],
            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
            //['Link','Unlink','Anchor'],
            ['Image'], //,'PageBreak','HorizontalRule','Flash', 'Table', 'Smiley', 'SpecialChar'
            //'/',
            ['Styles', 'Format', 'Font', 'FontSize'],
            ['TextColor', 'BGColor'],
                    //['Maximize', 'ShowBlocks','-','About','EqnEditor']
        ]
                //'Basic',
                //filebrowserBrowseUrl: 'librerias/php/kcfinder//filemanager/index.php',
                //filebrowserUploadUrl: 'uploader/upload.php',
                /*filebrowserBrowseUrl: 'librerias/php/kcfinder/browse.php?opener=ckeditor&type=files',
                 filebrowserImageBrowseUrl: 'librerias/php/kcfinder/browse.php?opener=ckeditor&type=images',
                 filebrowserFlashBrowseUrl: 'librerias/php/kcfinder/browse.php?opener=ckeditor&type=flash',
                 filebrowserUploadUrl: 'librerias/php/kcfinder/upload.php?opener=ckeditor&type=files',
                 filebrowserImageUploadUrl: 'librerias/php/kcfinder/upload.php?opener=ckeditor&type=images',
                 filebrowserFlashUploadUrl: 'librerias/php/kcfinder/upload.php?opener=ckeditor&type=flash',*/
    });
}


function Crear_revision() {

    id_doc = $("#registro_id").val();
    nombre = $("#nombre_revision").val();
    revision = $("#version_revision").val();
    descripcion = $("#descripcion_revision").val();
    adjunto = '';
    if ($('#adjunto_revision').val() != '') {
        adjunto = $('#adjunto_revision')[0].files[0].name;
    }

    if (id_doc == '' || revision == '' || descripcion == '' || adjunto == '') {

        alert('No se puede crear la revisión, debe haber algun campo vacio');
    }

    if (id_doc != '' && revision != '' && descripcion != '' && adjunto != '') {
        var datos = new FormData();
        var files = $('#adjunto_revision')[0].files;

        $.each(files, function (key, value)
        {
            datos.append('file', value);
        });

        datos.append('id_doc', $("#registro_id").val());
        datos.append('nombre', $("#nombre").val());
        datos.append('revision', $("#version_revision").val());
        datos.append('descripcion', $("#descripcion_revision").val());

        $.ajax({
            type: "POST",
            url: 'index.php?modulo=documentos&accion=crear_revision',
            data: datos,
            dataType: "json",
            processData: false,
            contentType: false
        }).done(function (result) {
            version = result[2];
            $(".version").html(version);
            $(".version").val(version);
            $(".dir").prop("href", "uploads/adjuntos/" + result[1]);
            $(".dir").html(result[0]);
            $("#versiones").html('');

            recargar_versiones();

            $('#nuevo_revision').find('input,select,textarea').val('');
            $('#nuevo_revision').modal('hide');
        });
    }
}

function recargar_versiones() {
    var id = $("#registro_id").val();
    $.ajax({
        type: "POST",
        url: 'index.php?modulo=documentos&accion=obtener_revisiones',
        data: 'id=' + id,
        dataType: "json",
    }).done(function (result) {
        var version = '';
        for (i = 0; i < result.length; i++) {
            version += '<div class="clearfix"></div>';
            version += ' <div class="col-md-3 no-padding-left">';
            version += ' <a href="uploads/adjuntos/' + result[i]['adjunto'] + '" target="blank"><i class="fa fa-paperclip"></i></a> ';
            version += result[i]['nombre_adjunto'];
            version += ' </div>';
            version += '  <div class="col-md-2 no-padding-left">';
            version += result[i]['version'];
            version += ' </div>';
            version += '  <div class="col-md-2 no-padding-left">';
            version += result[i]['fecha_creacion'];
            version += '</div>'
            version += '<div class="col-md-2 no-padding-left">';
            version += result[i]['nombre_usuario'];
            version += '</div>'
                    + '<div class="col-md-3 no-padding-left">';
            version += result[i]['descripcion'];
            version += '</div>'
            version += '<div class="clearfix"></div>';
        }
        $("#versiones").html(version);
    });
}


function quitar_documento(obj) {
    var id_act = $(obj).attr('id_doc');
    var r = confirm("Esta Seguro de Eliminar el Documento?");
    if (r == true) {
        $.ajax({
            type: "POST",
            url: 'index.php?modulo=documentos&accion=quitar_documento',
            data: 'id=' + id_act,
            dataType: "json",
        }).done(function (result) {
            cargar_documentos();
            crearTablaListaDocumentos();
        });
    }
}


function crear_documento() {
    if (validarDocumento()) {
        if ($("#form_documento").validationEngine('validate')) {
            var datosd = new FormData();
            var files = $('#adjunto_nuevo')[0].files;
            $.each(files, function (key, value) {
                datosd.append('adjunto', value);
            });

            datosd.append('nombre', $("#nombre_nuevo").val());
            datosd.append('tipo_documento', $("#tipo_documento_nuevo").val());
            datosd.append('modulo_relacionado', $("#modulo_relacionado_nuevo").val());
            datosd.append('modulo_relacionado_id_nuevo', $("#modulo_relacionado_id_nuevo").val());
            datosd.append('version', $("#version_nuevo").val());
            datosd.append('categoria', $("#categoria_nuevo").val());
            datosd.append('estado', $("#estado_nuevo").val());
            datosd.append('fecha_publicacion', $("#fecha_publicacion_nuevo").val());
            datosd.append('descripcion', $("#descripcion_nuevo").val());

            $.ajax({
                type: "POST",
                url: 'index.php?modulo=documentos&accion=crear_documento',
                data: datosd,
                dataType: "json",
                processData: false,
                contentType: false
            }).done(function (result) {
                if (result == '0') {
                    alert('No se ha creado el registro, por favor verifique el tipo de adjunto');
                }
                cargar_documentos();

            });
        }
    }
}
function crear_actividad() {
    var x = $('input[id^=email_actividad]').length;
    $.each($("#form_actividad .select2-container"), function ($k, $v) {
        $("#" + $v.id).removeClass("validate[required]");
    });

    var bandera = $('#form_actividad').validationEngine('validate');
    cargaDatePicker();
    if ($("#tipo_actividad").val() == '40') {
        if (x > 0) {

        } else {
            alert('Debe existir almenos un Invitado');
            bandera = false;
        }

    }
    if (bandera) {
        var formData = new FormData($("#form_actividad")[0]);
        $.ajax({
            url: 'index.php?modulo=actividades&accion=crear_actividad',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function (result) {
            $('#nuevo_actividad').find('input,select,textarea').val('');
            $('select[name^="fecha_"]').select2('val', 'All');
            $('#nuevo_actividad').modal('hide');
            cargar_actividades();
        });

    }
}

function crear_oportunidad() {

    $.each($("#form_opp .select2-container"), function ($k, $v) {
        //console.log($v.id);
        $("#" + $v.id).removeClass("validate[required]");
    });

    var bandera = $('#form_opp').validationEngine('validate');
    cargaDatePicker();

    if (bandera) {
        var formData = new FormData($("#form_opp")[0]);

        $.ajax({
            url: 'index.php?modulo=oportunidades&accion=crear_oportunidad',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#nueva_oportunidad').find('input,select,textarea').val('');
            $('#nueva_oportunidad').modal('hide');
            cargar_oportunidades();
        });

    }
}
function crear_convenio() {

    $.each($("#form_convenio .select2-container"), function ($k, $v) {
        //console.log($v.id);
        $("#" + $v.id).removeClass("validate[required]");
    });

    var bandera = $('#form_convenio').validationEngine('validate');
    cargaDatePicker();

    if (bandera) {
        var formData = new FormData($("#form_convenio")[0]);

        $.ajax({
            url: 'index.php?modulo=convenios&accion=crear_convenio',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
//            $('#nuevo_convenio').find('input,select,textarea').val('');
            $('#nuevo_convenio').modal('hide');
            cargar_convenios();
        });

    }
}
function crear_servicio() {

    $.each($("#form_servicio .select2-container"), function ($k, $v) {
        //console.log($v.id);
        $("#" + $v.id).removeClass("validate[required]");
    });

    var bandera = $('#form_servicio').validationEngine('validate');
    cargaDatePicker();

    if (bandera) {
        var formData = new FormData($("#form_servicio")[0]);

        $.ajax({
            url: 'index.php?modulo=servicios&accion=crear_servicio',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
//            $('#nuevo_servicio').find('input,select,textarea').val('');
            $('#nuevo_servicio').modal('hide');
            cargar_servicios();
        });

    }
}
function crear_opp_contact() {

    $.each($("#form_asig_contac .select2-container"), function ($k, $v) {
        //console.log($v.id);
        $("#" + $v.id).removeClass("validate[required]");
    });

    var bandera = $('#form_asig_contac').validationEngine('validate');
    if (bandera) {
        var formData = new FormData($("#form_asig_contac")[0]);

        $.ajax({
            url: 'index.php?modulo=oportunidades&accion=crear_opp_contact',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#nueva_asignado_contacto').find('select').val('');
            $('#nueva_asignado_contacto').modal('hide');
            cargar_contactos();
        });
    }
}
function crear_contact_opp() {

    $.each($("#form_asig_oportu .select2-container"), function ($k, $v) {
        //console.log($v.id);
        $("#" + $v.id).removeClass("validate[required]");
    });

    var bandera = $('#form_asig_oportu').validationEngine('validate');
    if (bandera) {
        var formData = new FormData($("#form_asig_oportu")[0]);

        $.ajax({
            url: 'index.php?modulo=contactos&accion=crear_contact_opp',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#nueva_asignado_oportu').find('select').val('');
            $('#nueva_asignado_oportu').modal('hide');
            cargar_oportunidades();
        });
    }
}

function crear_cotizacion() {

    $.each($("#form_cot .select2-container"), function ($k, $v) {
        //console.log($v.id);
        $("#" + $v.id).removeClass("validate[required]");
    });

    var bandera = $('#form_cot').validationEngine('validate');
    cargaDatePicker();

    if (bandera) {
        var formData = new FormData($("#form_cot")[0]);

        $.ajax({
            url: 'index.php?modulo=cotizaciones&accion=crear_cotizacion',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#nueva_cotizacion').find('input,select,textarea').val('');
            $('#nueva_cotizacion').modal('hide');
            cargar_cotizaciones();
        });

    }
}

function crear_contacto() {

    $.each($("#form_cont .select2-container"), function ($k, $v) {
        //console.log($v.id);
        $("#" + $v.id).removeClass("validate[required]");
    });

    var bandera = $('#form_cont').validationEngine('validate');
    cargaDatePicker();

    if (bandera) {
        var formData = new FormData($("#form_cont")[0]);

        $.ajax({
            url: 'index.php?modulo=contactos&accion=crear_contacto',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        }).done(function (result) {
            $('#nuevo_contacto').find('input,select,textarea').val('');
            $('#nuevo_contacto').modal('hide');
            cargar_contactos();
        });

    }
}

function crear_caso() {

    //$('#nuevo_caso').append('<form id="form_caso" ></form>');
    //$('#form_caso').html($('#nuevo_caso .modal-body').clone());

    if (validarCaso()) {

        var datosd = $("#form_caso").serialize();

        $.ajax({
            type: "POST",
            url: 'index.php?modulo=casos&accion=crearCasoPanelDerecho',
            data: datosd,
            dataType: "json",
        }).done(function (result) {
            $('#nuevo_caso').find('input,select,textarea').val('');
            $('#nuevo_caso').modal('hide');
            cargar_casos();
        });

    }
}

function validarDocumento() {

    if (validar_datos('#form_documento')) {
        return true;
    } else {

        alert('Algunos datos no son validos, por favor verifique he intente nuevamente.');
        return false;
    }
}
function validarActividades() {
    var bandera = true;
    $.each($('#nuevo_actividad .addreq'), function (k, v) {
        if (!$('#nuevo_actividad #' + $(v).attr('id')).do) {
            bandera = false;
        }
    });
    return bandera;

}

$(document).ready(function () {
   
   $('.fecha').datepicker().on('changeDate', function (ev) {      
      $('.formError').remove();
   });
   
    $('.cuentaRO').select2('readonly', true);
    /*Dejar por defecto la cuenta que tiene el registro actual [3.oct.2016]*/
    $('#nuevo_contacto #cuenta_id').html('<option value="' + $('#sel_cuenta_id').attr('data-id') + '">' + $('#sel_cuenta_id').text() + '</option>');
    $('#nuevo_contacto #cuenta_id').select2('val', $('#sel_cuenta_id').attr('data-id'));
    //Elimina el campo de estado [3.oct.2016]
    $('#nuevo_contacto #estado_id').parent().parent().remove();
    //Implementacion de autcompletar ubicacion en el modal de  'Crear Conracto'
    autocompletarUbicacion('#nuevo_contacto #view_ubicacion_id');

    $('#btn_agregar_detalle_cotizacion').click(function () {
        agregarNuevoDetalleCotizacion();
    });
    triggersDetalle_cotizacion();

    $(".modal-transparent").on('show.bs.modal', function () {
        setTimeout(function () {
            $(".modal-backdrop").addClass("modal-backdrop-transparent");
        }, 0);
    });
    $(".modal-transparent").on('hidden.bs.modal', function () {
        $(".modal-backdrop").addClass("modal-backdrop-transparent");
    });

    $("#cuenta_id").change(function () {
        buscaOportunidadesXCuenta($("#cuenta_id").val());
    });

    $("#iva").change(function (k, v) {
        calcularTotal();
    });
    try {
        if (s3vars.registro.id > 0) {
//    agregarDetalleCotizacion();
        } else {
            $("#descuento").val(0);
            $("#subtotal").val(0);
            $("#subtotal_descuento").val(0);
            $("#valor_iva").val(0);
            $("#total").val(0);

        }
    } catch (ex) {
        console.log(ex);

    }

    $("#btn_enviar_correo").unbind('click').click(function () {
        enviarCotizacionCorreo();
    });

//  cargarEditor();

    $(".adjunto_documento").change(function () {
        adjunto(this);
    });

    $('#nuevo_documento').on('hidden.bs.modal', function (e) {
        $("#nuevo_documento").find('input,select,textarea').removeClass('required');
        $('.limpiar_nuevo_documento').find('input,textarea').val('');
        $("#tipo_documento_nuevo").select2("val", "-1");
        $("#categoria_nuevo").select2("val", "-1");
        $("#estado_nuevo").select2("val", "-1");
    });

    $('#nuevo_documento').on('show.bs.modal', function (e) {
        $("#nombre_nuevo").addClass('required');
        $("#modulo_relacionado_nuevo").addClass('required');
        $("#adjunto_nuevo").addClass('required');
        $("#version_nuevo").addClass('required');

    });

    $('#nuevo_revision').on('hidden.bs.modal', function (e) {
        $('#nuevo_revision').find('input,textarea').val('');
    });

    $('#nuevo_actividad').on('show.bs.modal', function (e) {

        try {
            var target_id = e.relatedTarget.id;
            var id = s3vars.registro.id;
            var modulo_id = s3vars.relacionado;
            $("#relacionado_id_actividad").val(id);
            $("#relacionado_actividad").val(modulo_id);
            $("#relacionado_acti_vidad").val(modulo_id);
            $(".tipo_actividad").html('');
            if (target_id == '1') {
                $("#tipo_actividad").val('40');
                $(".tipo_actividad").html('Reunión');
            }
            if (target_id == '2') {
                $("#tipo_actividad").val('39');
                $(".tipo_actividad").html('Llamada');
            }
            if (target_id == '3') {
                $("#tipo_actividad").val('38');
                $(".tipo_actividad").html('Tarea');
            }

        } catch (e) {
            console.log(e);
        }
        selectChange($("#tipo_actividad"));
        campos_tipo();
        $('#nuevo_actividad .addreq').addClass('validate[required]');
    });

    $('#nuevo_actividad').on('hidden.bs.modal', function (e) {
        $("#nuevo_actividad").find('input,select,textarea').removeClass('required');
        $('#nuevo_actividad').find('input,select,textarea').val('');
        $(".addreq").select2("val", "");
        $("#invitados").html('');
        $('#nuevo_actividad .addreq').removeClass('validate[required]');
        $('#nuevo_actividad .formError').remove();
        $('#form_actividades').remove();
    });

    $('#nuevo_actividad').find('input,select,textarea').val('');

    /* ACTIVAR LISTADOS PARA RELACIONADOS */
    $('#lista_actividades').on('show.bs.modal', function (e) {
        var target_id = e.relatedTarget.id;

        if (target_id == '1') {
            crearTablaListaTareas(1);
        }
        if (target_id == '2') {
            crearTablaListaTareas(2);
        }
        if (target_id == '3') {
            crearTablaListaTareas(3);
        }
    });
    $('#lista_documentos').on('show.bs.modal', function (e) {
        crearTablaListaDocumentos();
    });
    $('#lista_contactos').on('show.bs.modal', function (e) {
        crearTablaListaContactos();
    });
    $('#lista_cotizaciones').on('show.bs.modal', function (e) {
        crearTablaListaCotizaciones();
    });
    $('#lista_oportunidades').on('show.bs.modal', function (e) {
        crearTablaListaOportunidades();
    });
    $('#listar_convenios').on('show.bs.modal', function (e) {
        crearTablaListaConvenios();
    });
    $('#listar_servicios').on('show.bs.modal', function (e) {
        crearTablaListaServicios();
    });
    $('#listar_casos').on('show.bs.modal', function (e) {
        crearTablaListaCasos();
    });


    $("#tipo_documento_nuevo").change(function () {

        verificar_campos_tipo_nuevo();
    });
    $("#tipo_documento").change(function () {

        verificar_campos_tipo();
    });

    actividades = '';
    campos_tipo();

    $("#tipo_actividad").change(function () {
        campos_tipo();
    });

});


function verificar_campos_tipo() {
    if ($("#tipo_documento").val() == '195') {
        $("#depende_estado").show();
        $("#estado").addClass('required');
        $("#fecha_publicacion").addClass('required');
    }
    if ($("#tipo_documento").val() == '196') {
        $("#depende_estado").hide();
        $("#estado").removeClass('required');
        $("#fecha_publicacion").removeClass('required');
    }

}
function verificar_campos_tipo_nuevo() {

    if ($("#tipo_documento_nuevo").val() == '195') {
        $("#depende_estado_nuevo").show();
        $("#estado_nuevo").addClass('required');
        $("#fecha_publicacion_nuevo").addClass('required');
    }
    if ($("#tipo_documento_nuevo").val() == '196') {
        $("#depende_estado_nuevo").hide();
        $("#estado_nuevo").removeClass('required');
        $("#fecha_publicacion_nuevo").removeClass('required');

    }
}

function del_actividad(obj) {
    var id_act = $(obj).attr('id_act');
    var r = confirm("Esta Seguro de Eliminar la Actividad");
    if (r == true) {
        $.ajax({
            type: "POST",
            url: 'index.php?modulo=actividades&accion=eliminar_actividad',
            data: 'id=' + id_act,
            dataType: "json",
        }).done(function (result) {
            cargar_actividades();

        });
    }
}

function campos_tipo() {
    op = $("#tipo_actividad").val();
    console.log(op);
    if (op == 38) { // tarea

        $(".panel-tarea").show();
        $(".panel-tarea").find('input,select').removeAttr('disabled');
        $(".panel-tarea").find('.addreq').addClass('required');
        $(".panel-tarea").find('.addreq').addClass('required');
        $(".panel-llamada").find('.addreq').removeClass('required');
        $(".panel-llamada").find('.addreq').removeClass('required');
        $(".panel-llamada").find('input').removeClass('required');
        $(".panel-reunion").find('input').removeClass('required');



        $(".panel-llamada").hide();
        $(".panel-reunion").hide();
        $(".panel-llamada").find('input,select').attr('disabled', 'disabled');
        $(".panel-reunion").find('input,select').attr('disabled', 'disabled');
    }
    if (op == 39) {
        $(".panel-llamada").show();
        $(".panel-llamada").find('input,select').removeAttr('disabled');
        $(".panel-llamada").find('.addreq').addClass('required');
        $(".panel-tarea").find('.addreq').removeClass('required');
        $(".panel-reunion").find('.addreq').removeClass('required');
        $(".panel-tarea").hide();
        $(".panel-reunion").hide();
        $(".panel-tarea").find('input,select').attr('disabled', 'disabled');
        $(".panel-reunion").find('input,select').attr('disabled', 'disabled');
    }
    if (op == 40) {
        $(".panel-reunion").show();
        $(".panel-reunion").find('input,select').removeAttr('disabled');
        $(".panel-reunion").find('.addreq').addClass('required');
        $(".panel-llamada").find('.addreq').removeClass('required');
        $(".panel-tarea").find('.addreq').removeClass('required');
        $(".panel-llamada").hide();
        $(".panel-tarea").hide();
        $(".panel-llamada").find('input,select').attr('disabled', 'disabled');
        $(".panel-tarea").find('input,select').attr('disabled', 'disabled');
    }
}



function set_estado_calendario(obj) {

    campos_tipo_calendario();
    id = $(obj).val();
    op = '<option value ="-1">Seleccionar</option>';
    if (id == 38) {
        for (key in s3vars.listas_actividades['estado_tarea']) {
            op += "<option value='" + s3vars.listas_actividades['estado_tarea'][key]['id'] + "'";
            op += ">" + s3vars.listas_actividades['estado_tarea'][key]['nombre'] + "</option>";
        }
    }
    if (id == 39 || id == 40) {
        for (key in s3vars.listas_actividades['estado_llamada']) {
            op += "<option value='" + s3vars.listas_actividades['estado_llamada'][key]['id'] + "'";
            op += ">" + s3vars.listas_actividades['estado_llamada'][key]['nombre'] + "</option>";
        }
    }

    $("#estado").html('');
    $("#estado").append(op);
    $("#estado").select2('val', '-1');
}

function set_relacionado(obj) {
    $("#load-buscar-relacionado").removeClass('hidden');
    id = $(obj).val();
    tabla = '';
    campos = '';
    op_mod_rel = '<option value="-1">Seleccionar</option>';
    for (key in s3vars.modulos_actividades) {
        if (id == s3vars.modulos_actividades[key]['id']) {
            tabla = s3vars.modulos_actividades[key]['tabla'];
            selecion = s3vars.modulos_actividades[key]['select'];

        }
    }
    $.ajax({
        type: "POST",
        url: 'index.php?modulo=actividades&accion=obtener_registrosxmodulo',
        data: {tabla: tabla, selecion: selecion},
        cache: false,
        dataType: "json",
        async: false,
    }).done(function (result) {

        if (result.length > 0) {
            for (key in result) {
                op_mod_rel += "<option value='" + result[key]['ref_id'] + "'";
                op_mod_rel += ">" + result[key]['ref'] + "</option>";
            }
        }
        $("#load-buscar-relacionado").addClass('hidden');

    });
    $("#relacionado_id").html('');
    $("#relacionado_id").append(op_mod_rel);
    $("#relacionado_id").select2("val", "-1");

}

function validarFormulario_calendario() {

    $.each($(".select2-container"), function ($k, $v) {
        //console.log($v.id);
        $("#" + $v.id).removeClass("validate[required]");
    });

    var bandera = $('#form_actividades').validationEngine('validate');

    console.log(bandera);//validar_datos('#form_actividades')
    if (bandera) {
        return true;
    } else {
        //alert('Algunos datos no son validos, por favor verifique he intente nuevamente.');
        return false;
    }
}

var tablaPopups = null;

function crearTablaListaTareas(x) {
    cargar_actividades();
    var table = $('#tabla_listar_tareas').DataTable();
    table.destroy();

    if (x == 1 || x == 'Reunion') {
        datos_tabla = actividades['reunion'];
    }
    if (x == 2 || x == 'Llamada') {
        datos_tabla = actividades['llamada'];
    }
    if (x == 3 || x == 'Tarea') {
        datos_tabla = actividades['tarea'];
    }


    tablaPopups = $('#tabla_listar_tareas').dataTable({
        "ordering": false,
        data: datos_tabla,
        "columns": col_act,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $.each($(nRow).find('td'), function (a, b) {
                if (a == '9') {
                    $(b).addClass('del_act');
                    $(b).attr('id_act', aData.id);
                    $(b).attr('tipo', aData.tipo);
                    $(b).attr('onclick', 'eliminar_actividad(this)');
                }

                if (a == 1) {
                    $(b).html('<a class="zoom-panel-der">' + $(b).text() + '</a>');
                    $(b).click(function () {
                        location.href = "index.php?modulo=actividades&accion=editar&registro=" + aData.id;
                    });
                }
            });

        }
    });
}

$(".del_act").on('click', function () {
    eliminar_actividad($(this));
});

function eliminar_actividad(obj) {

    var r = confirm("Esta Seguro de Eliminar la Actividad");
    if (r == true) {
        $.ajax({
            type: "GET",
            url: 'index.php?modulo=actividades&accion=eliminar_actividad',
            data: 'id=' + $(obj).attr('id_act'),
            dataType: "json",
            async: false
        }).done(function (result) {
            crearTablaListaTareas($(obj).attr('tipo'));
        });
    }
}

function adjunto(obj) {
    var ext = $(obj).val().split('.').pop().toLowerCase();
    if ($.inArray(ext, ['doc', 'docx', 'pdf', 'xls', 'xlsx', 'txt']) == -1) {
        alert('Documento no valido!');
        $(obj).val('');
        $(obj).parent().parent().addClass('has-error')
    }
}




/* CARGUE DE PANEL DE RELACIONES */

function cargar_documentos() {

    $.ajax({
        type: "POST",
        url: 'index.php?modulo=documentos&accion=obtener_documentos',
        data: 'modulo_id=' + s3vars.registro.id + '&modulo_name=' + s3vars.modulo,
        dataType: "json",
    }).done(function (result) {

        documentos = '';
        documentos = result;
        $("#docs").html('');
        docs = result['count_doc'];
        $("#docs").append(docs);
    });


    $('.limpiar_nuevo_documento').find('input,select,textarea').val('');
    $('#nuevo_documento').modal('hide');
}

function cargar_actividades() {

    var id = s3vars.registro.id;
    var modulo_id = s3vars.relacionado;

    $("#relacionado_id_actividad").val(id);
    $("#relacionado_acti_vidad").val(modulo_id);

    $.ajax({
        type: "POST",
        url: 'index.php?modulo=actividades&accion=obtener_actividadesxmodulo',
        data: 'modulo_id=' + s3vars.registro.id + '&modulo_name=' + s3vars.modulo,
        dataType: "json",
        async: false
    }).done(function (result) {

        actividades = '';
        actividades = result;
        col_act = '';
        col_act = result['campos'];

        $("#meet").html('');
        $("#call").html('');
        $("#tas").html('');
        $("#meet").append(result['cnt_reunion']);
        $("#call").append(result['cnt_llamada']);
        $("#tas").append(result['cnt_tarea']);
        llamada = '';
        reunion = '';
        tarea = '';
    });

}

function cargar_oportunidades() {

    $.ajax({
        type: "POST",
        url: 'index.php?modulo=oportunidades&accion=oportunidadXModulo',
        data: 'modulo_id=' + s3vars.registro.id + '&modulo_name=' + s3vars.modulo,
        dataType: "json",
    }).done(function (result) {

        oportunidades = '';
        oportunidades = result;
        $("#opps").html('');
        opps = result['count_opps'];
        $("#opps").append(opps);
    });


    $('.limpiar_nueva_oportunidad').find('input,select,textarea').val('');
    $('#nueva_oportunidad').modal('hide');
}

function cargar_convenios() {

    $.ajax({
        type: "POST",
        url: 'index.php?modulo=convenios&accion=convenioXModulo',
        data: 'modulo_id=' + s3vars.registro.id + '&modulo_name=' + s3vars.modulo,
        dataType: "json",
    }).done(function (result) {

        convenios = '';
        convenios = result;
        $("#cnv").html('');
        cnv = result['count_cnv'];
        $("#cnv").append(cnv);
    });


//    $('#nuevo_convenio').find('input,select,textarea').val('');
    $('#nuevo_convenio').modal('hide');
}

function cargar_servicios() {

    $.ajax({
        type: "POST",
        url: 'index.php?modulo=servicios&accion=servicioXModulo',
        data: 'modulo_id=' + s3vars.registro.id + '&modulo_name=' + s3vars.modulo,
        dataType: "json",
    }).done(function (result) {

        servicios = '';
        servicios = result;
        $("#serv").html('');
        serv = result['count_serv'];
        $("#serv").append(serv);
    });


//    $('#nuevo_servicio').find('input,select,textarea').val('');
    $('#nuevo_servicio').modal('hide');
}

function cargar_contactos() {

    $.ajax({
        type: "POST",
        url: 'index.php?modulo=contactos&accion=contactosXModulo',
        data: 'modulo_id=' + s3vars.registro.id + '&modulo_name=' + s3vars.modulo,
        dataType: "json",
    }).done(function (result) {

        contactos = '';
        contactos = result;
        $("#cntcts").html('');
        cntcts = result['count_cntcts'];
        $("#cntcts").append(cntcts);
    });


    $('.limpiar_nueva_contacto').find('input,select,textarea').val('');
    $('#nueva_contacto').modal('hide');
}

function cargar_cotizaciones() {

    $.ajax({
        type: "POST",
        url: 'index.php?modulo=cotizaciones&accion=cotizacionesXModulo',
        data: 'modulo_id=' + s3vars.registro.id + '&modulo_name=' + s3vars.modulo + '&modulo_cuenta=' + s3vars.registro.cuenta_id,
        dataType: "json",
    }).done(function (result) {

        cotizaciones = '';
        cotizaciones = result;
        $("#ctzcns").html('');
        ctzcns = result['count_ctzcns'];
        $("#ctzcns").append(ctzcns);
    });


    $('.limpiar_nueva_cotizacion').find('input,select,textarea').val('');
    $('#nueva_cotizacion').modal('hide');
}

function cargar_casos() {

    $.ajax({
        type: "POST",
        url: 'index.php?modulo=casos&accion=casosXModulo',
        data: 'modulo_id=' + s3vars.registro.id + '&modulo_name=' + s3vars.modulo,
        dataType: "json",
    }).done(function (result) {

        casos = '';
        casos = result;
        $("#css").html('');
        css = result['count_css'];
        $("#css").append(css);
    });


    $('.limpiar_nuevo_caso').find('input,select,textarea').val('');
    $('#nuevo_caso').modal('hide');
}

/* TABLA LISTADOS PANEL RELACIONES */
function crearTablaListaDocumentos() {

    var table_doc = $('#tabla_listar_documentos').DataTable();
    table_doc.destroy();

    tablaPopups = $('#tabla_listar_documentos').dataTable({
        "ordering": false,
        data: documentos['docs'],
        "columns": documentos['campos'],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $.each($(nRow).find('td'), function (a, b) {
                if (a == '1') {
                    $(b).html('<a class="zoom-panel-der" target="_blank" href="uploads/adjuntos/' + aData['adjunto'][0] + '" target="blank"><i class="fa fa-paperclip fa-lg"></i> ' + aData["adjunto"][1] + '</a>');
                }
                if (a == '3') {
                    $(b).addClass('del_doc');
                    $(b).attr('id_doc', aData.id);
                    $(b).attr('onclick', 'quitar_documento(this)');
                }
                if (a == 0 || a == 2) {
                    $(b).click(function () {
                        window.open("index.php?modulo=documentos&accion=editar&registro=" + aData.id);
                    });
                }
            });

        }
    });
}


function crearTablaListaContactos() {

    var tabla = $('#tabla_listar_contactos').DataTable();
    tabla.destroy();

    tablaPopups = $('#tabla_listar_contactos').dataTable({
        "ordering": false,
        data: contactos['cntcts'],
        "columns": contactos['campos'],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

            $.each($(nRow).find('td'), function (a, b) {

                if (a == 3) { //COLUMNA
                    $(b).addClass('del_cntcts');
                    $(b).attr('id_cntcts', aData.id);
                    $(b).attr('onclick', 'quitar_contactos(this)');
                }

                if (a == 1) {
                    $(b).html('<a class="zoom-panel-der">' + $(b).text() + '</a>');
                    $(b).click(function () {
                        window.open("index.php?modulo=contactos&accion=editar&registro=" + aData.id);
                    });
                }
            });

        }
    });

}


function crearTablaListaCotizaciones() {

    var tabla = $('#tabla_listar_cotizaciones').DataTable();
    tabla.destroy();

    tablaPopups = $('#tabla_listar_cotizaciones').dataTable({
        "ordering": false,
        data: cotizaciones['ctzcns'],
        "columns": cotizaciones['campos'],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

            $.each($(nRow).find('td'), function (a, b) {

                if (a == 3) { //COLUMNA
                    $(b).addClass('del_ctzcns');
                    $(b).attr('id_ctzcns', aData.id);
                    $(b).attr('onclick', 'quitar_cotizacion(this)');
                }

                if (a == 1) {
                    $(b).html('<a class="zoom-panel-der">' + $(b).text() + '</a>');
                    $(b).click(function () {
                        window.open("index.php?modulo=cotizaciones&accion=editar&registro=" + aData.id);
                    });
                }
            });
        }
    });

}

function crearTablaListaOportunidades() {

    var tabla = $('#tabla_listar_oportunidades').DataTable();
    tabla.destroy();

    tablaPopups = $('#tabla_listar_oportunidades').dataTable({
        "ordering": false,
        data: oportunidades['opps'],
        "columns": oportunidades['campos'],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

            $.each($(nRow).find('td'), function (a, b) {

                if (a == 3) { //COLUMNA
                    $(b).addClass('del_opps');
                    $(b).attr('id_opps', aData.id);
                    $(b).attr('onclick', 'quitar_oportunidad(this)');
                }

                if (a == 1) {
                    $(b).html('<a class="zoom-panel-der">' + $(b).text() + '</a>');
                    $(b).click(function () {
                        window.open("index.php?modulo=oportunidades&accion=editar&registro=" + aData.id);
                    });
                }
            });
        }
    });

}

function crearTablaListaConvenios() {

    var tabla = $('#tabla_listar_convenios').DataTable();
    tabla.destroy();
console.log(convenios['cnv']);
    tablaPopups = $('#tabla_listar_convenios').dataTable({
        "ordering": false,
        data: convenios['cnv'],
        "columns": convenios['campos'],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

            $.each($(nRow).find('td'), function (a, b) {

                if (a == 3) { //COLUMNA
                    $(b).addClass('del_cnv');
                    $(b).attr('id_cnv', aData.id);
                    $(b).attr('onclick', 'quitar_convenio(this)');
                }

                if (a == 1) {
                    $(b).html('<a class="zoom-panel-der">' + $(b).text() + '</a>');
                    $(b).click(function () {
                        window.open("index.php?modulo=convenios&accion=editar&registro=" + aData.id);
                    });
                }
            });
        }
    });

}

function crearTablaListaServicios() {
    var tabla = $('#tabla_listar_servicios').DataTable();
    tabla.destroy();

   tablaPopups = $('#tabla_listar_servicios').dataTable({
        "ordering": false,
        data: servicios['serv'],
        "columns": servicios['campos'],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

            $.each($(nRow).find('td'), function (a, b) {

                if (a == 3) { //COLUMNA
                    $(b).addClass('del_serv');
                    $(b).attr('id_serv', aData.id);
                    $(b).attr('onclick', 'quitar_servicio(this)');
                }

                if (a == 1) {
                    $(b).html('<a class="zoom-panel-der">' + $(b).text() + '</a>');
                    $(b).click(function () {
                        window.open("index.php?modulo=servicios&accion=editar&registro=" + aData.id);
                    });
                }
            });
        }
    });

}

function crearTablaListaCasos() {

    var tabla = $('#tabla_listar_casos').DataTable();
    tabla.destroy();

    tablaPopups = $('#tabla_listar_casos').dataTable({
        "ordering": false,
        data: casos['css'],
        "columns": casos['campos'],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

            $.each($(nRow).find('td'), function (a, b) {

                if (a == 3) { //COLUMNA
                    $(b).addClass('del_css');
                    $(b).attr('id_css', aData.id);
                    $(b).attr('onclick', 'quitar_caso(this)');
                }

                if (a == 1) {
                    $(b).html('<a class="zoom-panel-der">' + $(b).text() + '</a>');
                    $(b).click(function () {
                        window.open("index.php?modulo=casos&accion=editar&registro=" + aData.id);
                    });
                }
            });
        }
    });

}

function validarCaso() {

    if ($('#form_caso').validationEngine('validate')) {
        return true;
    } else {
        return false;
    }
}

