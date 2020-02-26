<?
try{
    if(isset($sectPolicy)) {
        $sectPolicy->gateGuardian($fabUsuario, FabUsuario::getNumberPerfis(), '0', 'proc-logoff.php?code=error0002');
    }else{
        echo '<script> location.replace("proc-logoff.php"); </script>';
    }
}catch (ErrorException $e){
    echo '<script> location.replace("proc-logoff.php"); </script>';
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="plus-circle"></span> Novo
        </button>
    </div>
</div>

<?php echo "teste"; ?>