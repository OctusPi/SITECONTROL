
$(document).ready(function () {
    //rescue id item table
    let itemTable = 0;

    //interaction itens table (CSS AND ACTIONS)
    $('.ocp-line-table').click(function () {
        //style js
        $('.ocp-line-table').removeClass('ocp-line-table-selected');
        $(this).addClass('ocp-line-table-selected');

        //actions js
        itemTable = $(this).attr('ocp-value');
    });

    //interaction update data target
    $('.ocp-upd-button').click(function () {
        if(itemTable !== 0 && itemTable !== '' && itemTable !== null){
            let urlTarget = $(this).attr('ocp-url-target')+'&updtarget='+itemTable;
            window.location.replace(urlTarget);
        }else{
            let alt = '<div class="alert text-center small alert-warning alert-dismissible fade show" role="alert">'+
                 '<strong>ALERTA:</strong> Selecione um Item!'+
                 '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                 '<span aria-hidden="true">&times;</span>'+
                 '</button>'+
                 '</div>';

            $('#ocp-view-alertr').html(alt);
        }
    });

    //interaction delete data target
    $('.ocp-del-button').click(function () {
        if(itemTable !== 0 && itemTable !== '' && itemTable !== null){
            $('#ocp-modaldell').modal('show');
            $('#form-id').val(itemTable);
        }else{
            let alt = '<div class="alert text-center small alert-warning alert-dismissible fade show" role="alert">'+
                '<strong>ALERTA:</strong> Selecione um Item!'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
                '</div>';

            $('#ocp-view-alertr').html(alt);
        }
    });

    //interaction delimiter profile level
    $('#form-perfil-user').change(function () {
        let perfil = $(this).val();
        let check  = $('.ocp-nivel-check');
        let vince  = $('#form-escolas-user');
        let vincr  = $('#form-vinculo-user');

        check.prop("checked", false);
        check.prop("disabled", false);
        vincr.prop("disabled", false);

        if(perfil === '0'){
            check.prop("checked", true);
            vince.prop("disabled", true);
            vincr.prop("disabled", true);
        }else if(perfil === '1'){
            check.slice(1,12).prop("checked", true);
            check.slice(0,1).prop("disabled", true);
            vince.prop("disabled", true);
        }else if(perfil === '2'){
            check.slice(1,10).prop("checked", true);
            check.slice(0,1).prop("disabled", true);
            check.slice(10,12).prop("disabled", true);
            vince.prop("disabled", true);
        }else if(perfil === '3'){
            check.slice(4,5).prop("checked", true);
            check.slice(8,10).prop("checked", true);
            check.slice(0,4).prop("disabled", true);
            check.slice(5,8).prop("disabled", true);
            check.slice(10,12).prop("disabled", true);
            vince.prop("disabled", false);
        }
    });

    //alerts starts
    $('.alert').alert();
});



