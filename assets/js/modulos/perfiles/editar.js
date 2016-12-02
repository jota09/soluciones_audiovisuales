function cambiar_nivel_acesso(op) {
    switch (op.val()) {
        case '1':
            $('#slc_' + op.attr('select_id')).removeAttr('disabled');
            break;
        case '0':
            $('#slc_' + op.attr('select_id')).attr('disabled', 'disabled');
            $('#slc_' + op.attr('select_id')).select2('val', '-1');
            break;
    }
}
$(document).ready(function () {
    $('.chk_perfil').change(function () {
        cambiar_nivel_acesso($(this));
    });
});