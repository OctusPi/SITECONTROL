<?php
$pageUrl = isset($_GET['pag']) ? CTSecuritySystem::validateFormInput($_GET['pag']) : '';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light ocp-ul-nav-min">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="nav ocp-ul-nav-min">
            <?php if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('regioes',0,'1'))){?>
                <li class="nav-item text-center active">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('regioes'); ?>">
                        <img src="../imgs/icones/icons8-place-marker-100.png" alt="" width="28" height="28" title="Regiões"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('regioes'))){echo 'text-primary'; }?>">Regiões</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('escolas',1,'2'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('escolas'); ?>">
                        <img src="../imgs/icones/icons8-home-100.png" alt="" width="28" height="28" title="Escolas"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('escolas'))){echo 'text-primary'; }?>">Escolas</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('series',1,'3'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('series'); ?>">
                        <img src="../imgs/icones/icons8-flow-chart-100.png" alt="" width="28" height="28" title="Séries"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('series'))){echo 'text-primary'; }?>">Séries</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('turmas',1,'4'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('turmas'); ?>">
                        <img src="../imgs/icones/icons8-compare-100.png" alt="" width="28" height="28" title="Turmas"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('turmas'))){echo 'text-primary'; }?>">Turmas</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('alunos',3,'5'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('alunos'); ?>">
                        <img src="../imgs/icones/icons8-myspace-100.png" alt="" width="28" height="28" title="Alunos"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('alunos'))){echo 'text-primary'; }?>">Alunos</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('disciplinas',2,'6'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('disciplinas'); ?>">
                        <img src="../imgs/icones/icons8-about-100.png" alt="" width="28" height="28" title="Disciplinas"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('disciplinas'))){echo 'text-primary'; }?>">Disciplinas</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('descritores',2,'7'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('descritores'); ?>">
                        <img src="../imgs/icones/icons8-compose-100.png" alt="" width="28" height="28" title="Descritores"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('descritores'))){echo 'text-primary'; }?>">Descritores</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('matrizes',2,'8'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('matrizes'); ?>">
                        <img src="../imgs/icones/icons8-bookmark-100.png" alt="" width="28" height="28" title="Matrizes"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('matrizes'))){echo 'text-primary'; }?>">Matrizes</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('avaliacoes',3,'9'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('avaliacoes'); ?>">
                        <img src="../imgs/icones/icons8-overview-100.png" alt="" width="28" height="28" title="Avaliacões"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('avaliacoes'))){echo 'text-primary'; }?>">Avaliacões</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('resultados',3,'10'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('resultados'); ?>">
                        <img src="../imgs/icones/icons8-graph-100.png" alt="" width="28" height="28" title="Resultados"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('resultados'))){echo 'text-primary'; }?>">Resultados</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('reports',3,'11'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('reports'); ?>">
                        <img src="../imgs/icones/icons8-bulleted-list-100.png" alt="" width="28" height="28" title="Relatórios"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('reports'))){echo 'text-primary'; }?>">Relatórios</small>
                    </a>
                </li>
            <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('tools',3,'12'))){ ?>
                <li class="nav-item text-center">
                    <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('tools'); ?>">
                        <img src="../imgs/icones/icons8-settings-100.png" alt="" width="28" height="28" title="Configs"><br>
                        <small class="<?php if(CTCredencialSystem::identifyPage($pageUrl, md5('tools'))){echo 'text-primary'; }?>">Configs</small>
                    </a>
                </li>
            <?php }?>
        </ul>
    </div>
</nav>