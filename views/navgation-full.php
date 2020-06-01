<nav>
    <ul class="ocp-ul-nav container">
        <?php if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('regioes',0,'1'))){?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('regioes'); ?>">
                <img src="../imgs/icones/icons8-place-marker-100.png" alt="" width="58" height="58" title="Regiões"><br>
                <small>Regiões</small>
            </a>
        </li>
        <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('escolas',1,'2'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('escolas'); ?>">
                <img src="../imgs/icones/icons8-home-100.png" alt="" width="58" height="58" title="Escolas"><br>
                <small>Escolas</small>
            </a>
        </li>
        <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('series',1,'3'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('series'); ?>">
                <img src="../imgs/icones/icons8-flow-chart-100.png" alt="" width="58" height="58" title="Séries"><br>
                <small>Séries</small>
            </a>
        </li>
        <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('turmas',1,'4'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('turmas'); ?>">
                <img src="../imgs/icones/icons8-compare-100.png" alt="" width="58" height="58" title="Turmas"><br>
                <small>Turmas</small>
            </a>
        </li>
        <?php }?>
    </ul>
    <ul class="ocp-ul-nav container">
        <?php if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('alunos',3,'5'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('alunos'); ?>">
                <img src="../imgs/icones/icons8-myspace-100.png" alt="" width="58" height="58" title="Alunos"><br>
                <small>Alunos</small>
            </a>
        </li>
        <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('disciplinas',2,'6'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('disciplinas'); ?>">
                <img src="../imgs/icones/icons8-about-100.png" alt="" width="58" height="58" title="Disciplinas"><br>
                <small>Disciplinas</small>
            </a>
        </li>
        <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('descritores',2,'7'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('descritores'); ?>">
                <img src="../imgs/icones/icons8-compose-100.png" alt="" width="58" height="58" title="Descritores"><br>
                <small>Descritores</small>
            </a>
        </li>
        <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('matrizes',2,'8'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('matrizes'); ?>">
                <img src="../imgs/icones/icons8-bookmark-100.png" alt="" width="58" height="58" title="Matrizes"><br>
                <small>Matrizes</small>
            </a>
        </li>
        <?php }?>
    </ul>
    <ul class="ocp-ul-nav container">
        <?php if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('avaliacoes',3,'9'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('avaliacoes'); ?>">
                <img src="../imgs/icones/icons8-overview-100.png" alt="" width="58" height="58" title="Avaliacões"><br>
                <small>Avaliacões</small>
            </a>
        </li>
        <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('resultados',3,'10'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('resultados'); ?>">
                <img src="../imgs/icones/icons8-graph-100.png" alt="" width="58" height="58" title="Resultados"><br>
                <small>Resultados</small>
            </a>
        </li>
        <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('reports',3,'11'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('reports'); ?>">
                <img src="../imgs/icones/icons8-bulleted-list-100.png" alt="" width="58" height="58" title="Relatórios"><br>
                <small>Relatórios</small>
            </a>
        </li>
        <?php } if(CTSecuritySystem::verifyNivelCrendicial($loggedUser, new CTCredencialSystem('tools',3,'12'))){ ?>
        <li class="nav-item text-center">
            <a class="nav-link ocp-title-item-nav text-black-50" href="?pag=<?php echo md5('tools'); ?>">
                <img src="../imgs/icones/icons8-settings-100.png" alt="" width="58" height="58" title="Configs"><br>
                <small>Configs</small>
            </a>
        </li>
        <?php }?>
    </ul>
</nav>