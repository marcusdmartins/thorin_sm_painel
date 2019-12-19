<aside id="sidebar" class="sidebar c-overflow">
    <div class="s-profile">
        <a href="" data-ma-action="profile-menu-toggle">
            <div class="sp-pic">
                <img src="img/fotos/avatar_g.png" alt="">
            </div>

            <div class="sp-info">
                <?php echo "$_SESSION[UsuarioNome]" ?>
                <i class="zmdi zmdi-caret-down"></i>
            </div>
        </a>

        <ul class="main-menu">
            <li>
                <a href="perfil.php"><i class="zmdi zmdi-account"></i> Perfil</a>
            </li>

            <li>
                <a data-toggle="modal" href="#modalSenha"><i class="zmdi zmdi-settings"></i> Alterar senha</a>
            </li>
            <li>
                <a href="classes/logout.php"><i class="zmdi zmdi-time-restore"></i> Sair</a>
            </li>
        </ul>
    </div>

    <ul class="main-menu">
        <li><a href="home"><i class="zmdi zmdi-home"></i> Home</a></li>
        
        <?php
            $rotinas = ManagerSession::buscaItensMenu($_SESSION['UsuarioTipo']);
            
            foreach ($rotinas as $rotina){
        ?>
        <li class="sub-menu">
            <a href="" data-ma-action="submenu-toggle"><i class="<?php echo $rotina->icon ?>"></i> <?php echo $rotina->nome ?></a>
                <ul>
                    <?php
                            foreach ($rotina->subRotinas as $subRotinas){
                    ?>
                        <li><a href="<?php echo $subRotinas->path ?>"><?php echo $subRotinas->nome ?></a></li>
                    <?php
                            }
                    ?>
                </ul>
        </li> 
        <?php
            }
        if($_SESSION['UsuarioTipo'] == 1){
        ?>
        
        <li class="sub-menu">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-settings"></i> Configurações</a>
                <ul>
                    <li><a href="tiposUsuario">Perfis de usuário</a></li>
                    <li><a href="rotinas">Rotinas</a></li>
                </ul>
        </li> 

        <?php
            }
        ?>        

    </ul>
</aside>

<aside id="chat" class="sidebar">

    <div class="chat-search">
        <div class="fg-line">
            <input type="text" class="form-control" placeholder="Search People">
            <i class="zmdi zmdi-search"></i>
        </div>
    </div>
    
</aside>

<!-- Modal Default -->
<div class="modal fade" id="modalSenha" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar senha</h4>
            </div>
            <div class="container">
                <form action="classes/login.php" method="POST">
                    <input type="hidden" value="altera_senha" name="function" />
                    <input name="id" type="hidden" value="<?php echo $_SESSION['UsuarioID']; ?>">
                    <div class="form-group fg-line">
                        <input type="password" name="senha_atual" class="form-control input-sm" id="exampleInputEmail1"
                               placeholder="Senha atual">
                    </div>
                    <div class="form-group fg-line">
                        <input type="password" name="nova_senha" class="form-control input-sm" id="exampleInputPassword1"
                               placeholder="Nova senha">
                    </div>
                    <div class="form-group fg-line">
                        <input type="password" name="confirma_senha" class="form-control input-sm" id="exampleInputPassword1"
                               placeholder="Repita a nova senha">
                    </div>
                    <div class="form-group fg-line">
                        <button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
