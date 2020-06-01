<?php sleep(1);
//default includes
include_once('../autoload.php');

//default vars by load content
$ocpload = isset($_GET['ocpload']) ? CTSecuritySystem::validateFormInput($_GET['ocpload']) : null;
$valuser = isset($_GET['valuser']) ? CTSecuritySystem::validateFormInput($_GET['valuser']) : null;
$valkey  = isset($_GET['valkey'])  ? CTSecuritySystem::validateFormInput($_GET['valkey'])  : null;

//default instances
$ctSecurity = new CTSecuritySystem();
$impUsuario = new ImpUsuarioDao($ctSecurity);

//default objects
$loadUser = $impUsuario->findById($valuser);

//generic objects
$impload = null;
$objload = null;

if($ocpload != null && $loadUser != null && $valkey != null):
    switch ($ocpload){
        case 'escolas':
            $impload = new ImpEscolaDao($loadUser);
            $objload = $impload->findByRegiao($valkey);
            break;
        default:
            $impload = null;
            $objload = null;
            break;
    }
endif;
?>
<?php if($objload != null): foreach ($objload as $value):?>
    <option value="<?=$value->getId(); ?>"><?=$value->getNome(); ?></option>
<?php endforeach; endif; ?>
