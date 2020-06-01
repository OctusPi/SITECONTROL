
$(document).ready(function () {
    //load escolas by cidades
    $('.ocp-setload-cidades').change(function () {
        cidade  = $(this).val();
        ocpload = $(this).attr('ocpsetload');
        usuario = $(this).attr('ocpuser');
        if(cidade !== '' && ocpload !== '' && usuario !== ''){
            $('.ocp-getload-escolas').load('abs-loadbox-form.php?ocpload='+ocpload+'&valuser='+usuario+'&valkey='+cidade);
        }
    });
});

$(document).ajaxStart(function() {
    $('#ocp-progress-bar').css('visibility', 'visible');
    $('select').prop('disabled', true);
});

$(document).ajaxStop(function() {
    $('#ocp-progress-bar').css('visibility', 'hidden');
    $('select').prop('disabled', false);
});



