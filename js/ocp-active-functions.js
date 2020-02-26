$(document).ready(function () {
    var ocp = 0;

    $('.ocp-table table tr').click(function () {
        $('.ocp-table table tr').css('color', '#000').css('background', '#FFF');;
        $(this).css('color', '#FFF').css('background', '#337BCC');
        ocp = $(this).attr("valindex");
        $('#id_delete').val(ocp);
    });

    $('.ocp-btn-show').click(function () {
        var i = $('.ocp-btn-show').index(this);
        $('.ocp-hide').hide();
        $('.ocp-hide:eq('+i+')').show();
    });

    $('.ocp-btn-edit').click(function () {
        var url = $(this).attr('valurl')+ocp;
        if(ocp == 0){
            $('.ocp-alert').show();
        }else{
            $('.ocp-alert').hide();
            location.replace(url);
        }
    });

    $('.ocp-btn-delete').click(function () {
        if(ocp == 0){
            $('.ocp-alert').show();
        }else{
            $('.ocp-alert').hide();
            $('#modalDelete').modal();
        }
    });
});