<?php
require_once 'services/manager_session.php';
require_once 'services/pessoa.php';
require_once 'services/funcoes.php';
session_start();
ManagerSession::validaAcesso(5);
ManagerSession::setCookie();

if(!empty($_GET)){
    $dados = listarPessoa($_GET['i']);
    if($dados == "nenhum"){
        echo "<script>location.href='home'</script>";
    }
    
    if($dados->tipo_usuario != "6"){
        echo "<script>location.href='home'</script>";
    }       
    
    $alunos = buscaPorResponsavel($dados->id);
    
}else{
    echo "<script>location.href='home'</script>";
}

?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thorin</title>

    <!-- Vendor CSS -->

    <link href="vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <link href="vendors/bower_components/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
    <link href="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <link href="vendors/bower_components/mediaelement/build/mediaelementplayer.css" rel="stylesheet">
    <!-- CSS -->
    <link href="css/app_1.min.css" rel="stylesheet">
    <link href="css/app_2.min.css" rel="stylesheet">

</head>
<body>
    <?php include("topo.php") ?>

    <section id="main">
        <?php include ("menu.php") ?>
        <section id="content">
                <div class="container container-alt">

                    <div class="block-header">
                        <h2><?php echo $dados->nome ?>
                            <small><?php echo $dados->email ?></small>
                        </h2>

                        <ul class="actions m-t-20 hidden-xs">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Resetar senha</a>
                                    </li>
                                    <li>
                                        <a href="">Bloquear acesso</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="card" id="profile-main">
                        <div class="pm-overview c-overflow">

                            <div class="pmo-pic">
                                <div class="p-relative">
                                    <a href="">
                                        <img class="img-responsive" src="fotos/avatar.png" alt="">
                                    </a>

                                    <div class="dropdown pmop-message">
                                        <a data-toggle="dropdown" href="" class="btn bgm-white btn-float z-depth-1">
                                            <i class="zmdi zmdi-comment-text-alt"></i>
                                        </a>

                                        <div class="dropdown-menu">
                                            <textarea placeholder="Enviar uma mensagem..."></textarea>

                                            <button class="btn bgm-green btn-float"><i class="zmdi zmdi-mail-send"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="pmo-block pmo-contact hidden-xs">
                                <h2>Contatos</h2>

                                <ul>
                                    <li><i class="zmdi zmdi-phone"></i> <?php echo $dados->fone ?></li>
                                    <li><i class="zmdi zmdi-smartphone"></i> <?php echo $dados->celular ?></li>
                                    <li><i class="zmdi zmdi-email"></i> <?php echo $dados->email ?></li>
                                    <li><i class="zmdi zmdi-account"></i> <?php echo $dados->login ?></li>
                                    <li>
                                        <i class="zmdi zmdi-pin"></i>
                                        <address class="m-b-0 ng-binding">
                                            <?php echo $dados->rua.", ".$dados->numero.", ".$dados->complemento."<br>".$dados->bairro ?><br>
                                        </address>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="pm-body clearfix">
                            
                            <div class="card-body">
                                <ul class="tab-nav tn-justified tn-icon" role="tablist">
                                    <li role="presentation" class="active">
                                        <a class="col-sx-4" href="#tab-1" aria-controls="tab-1" role="tab"
                                           data-toggle="tab">
                                            <i class="zmdi zmdi-file-text icon-tab"></i> 
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a class="col-xs-4" href="#tab-2" aria-controls="tab-2" role="tab"
                                           data-toggle="tab">
                                            <i class="zmdi zmdi-accounts icon-tab"></i> 
                                        </a>
                                    </li>

                                </ul>

                                <div class="tab-content p-20">
                                    <div role="tabpanel" class="tab-pane animated fadeIn in active" id="tab-1">
                                    <div class="pmb-block">
                                        <div class="pmbb-header">
                                            <h2><i class="zmdi zmdi-account m-r-10"></i> Informações Básicas</h2>

                                            <ul class="actions">
                                                <li class="dropdown">
                                                    <a href="" data-toggle="dropdown">
                                                        <i class="zmdi zmdi-more-vert"></i>
                                                    </a>

                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li>
                                                            <a data-ma-action="profile-edit" href="">Editar</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="pmbb-body p-l-30">
                                            <div class="pmbb-view">
                                                <dl class="dl-horizontal">
                                                    <dt>Nome Completo</dt>
                                                    <dd><?php echo $dados->nome ?></dd>
                                                </dl>

                                                <dl class="dl-horizontal">
                                                    <dt>Data de Nascimento</dt>
                                                    <dd><?php echo formata_padrao_data($dados->dataNascimento)?></dd>
                                                </dl>

                                                <dl class="dl-horizontal">
                                                    <dt>Sexo</dt>
                                                    <dd><?php echo getSexo($dados->sexo)?></dd>
                                                </dl>  

                                                <dl class="dl-horizontal">
                                                    <dt>CPF</dt>
                                                    <dd><?php echo $dados->cpf ?></dd>
                                                </dl>
                                            </div>

                                            <div class="pmbb-edit">
                                                <form class="formularioInfos" action="services/pessoa.php" method="POST">
                                                    <!-- CAMPOS OCULTOS -->
                                                    <input type="hidden" name="function" value="edit"/>
                                                    <input type="hidden" name="id" value="<?php echo $dados->id ?>"/>
                                                    <input type="hidden" name="tipoUsuario" value="6"/>
                                                    <input type="hidden" name="id_responsavel" value=""/>
                                                    <input type="hidden" name="codigoInterno" value=""/>  
                                                    <input type="hidden" name="fone" value="<?php echo $dados->fone ?>"/>
                                                    <input type="hidden" name="celular" value="<?php echo $dados->celular ?>"/>
                                                    <input type="hidden" name="email" value="<?php echo $dados->email ?>"/>
                                                    <input type="hidden" name="login" value="<?php echo $dados->login ?>"/>
                                                    <input type="hidden" name="rua" value="<?php echo $dados->rua ?>"/>
                                                    <input type="hidden" name="numero" value="<?php echo $dados->numero ?>"/>
                                                    <input type="hidden" name="complemento" value="<?php echo $dados->complemento ?>"/>
                                                    <input type="hidden" name="bairro" value="<?php echo $dados->bairro ?>"/>
                                                    <input type="hidden" name="cep" value="<?php echo $dados->cep ?>"/>

                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Nome Completo</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" name="nome" value="<?php echo $dados->nome ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>

                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Data de Nascimento</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" data-mask="00/00/0000" name="dataNascimento" value="<?php echo formata_padrao_data($dados->dataNascimento) ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>                                        

                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Sexo</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <select class="form-control" name="sexo">
                                                                <?php
                                                                $sexos = getSexos();
                                                                foreach ($sexos as $sexo){
                                                                    $ab = $sexo["ab"];
                                                                    $nome = $sexo["nome"];
                                                                ?>
                                                                    <option value="<?php echo $ab?>" <?php if($dados->sexo == $ab){?> selected="" <?php }?>>
                                                                        <?php echo $nome ?>
                                                                    </option>
                                                                <?php }?>
                                                                </select>
                                                            </div>
                                                        </dd>
                                                    </dl>

                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">CPF</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" data-mask="000.000.000-00" name="cpf" value="<?php echo $dados->cpf ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>                                         

                                                    <div class="m-t-30">
                                                        <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                                        <button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancelar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class="pmb-block">
                                        <div class="pmbb-header">
                                            <h2><i class="zmdi zmdi-phone m-r-10"></i> Informações de Contato</h2>
                                            <ul class="actions">
                                                <li class="dropdown">
                                                    <a href="" data-toggle="dropdown">
                                                        <i class="zmdi zmdi-more-vert"></i>
                                                    </a>

                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li>
                                                            <a data-ma-action="profile-edit" href="">Editar</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="pmbb-body p-l-30">
                                            <div class="pmbb-view">
                                                <dl class="dl-horizontal">
                                                    <dt>Telefone</dt>
                                                    <dd><?php echo $dados->fone ?></dd>
                                                </dl>
                                                <dl class="dl-horizontal">
                                                    <dt>Celular</dt>
                                                    <dd><?php echo $dados->celular ?></dd>
                                                </dl>
                                                <dl class="dl-horizontal">
                                                    <dt>Email</dt>
                                                    <dd><?php echo $dados->email ?></dd>
                                                </dl>

                                                <dl class="dl-horizontal">
                                                    <dt>Nickname</dt>
                                                    <dd><?php echo $dados->login ?></dd>
                                                </dl>
                                                <dl class="dl-horizontal">
                                                    <dt>Rua</dt>
                                                    <dd><?php echo $dados->rua ?></dd>
                                                </dl>                                        
                                                <dl class="dl-horizontal">
                                                    <dt>Numero</dt>
                                                    <dd><?php echo $dados->numero ?></dd>
                                                </dl>
                                                <dl class="dl-horizontal">
                                                    <dt>Complemento</dt>
                                                    <dd><?php echo $dados->complemento ?></dd>
                                                </dl>
                                                <dl class="dl-horizontal">
                                                    <dt>Bairro</dt>
                                                    <dd><?php echo $dados->bairro ?></dd>
                                                </dl>
                                                <dl class="dl-horizontal">
                                                    <dt>CEP</dt>
                                                    <dd><?php echo $dados->cep ?></dd>
                                                </dl>                                        
                                            </div>

                                            <div class="pmbb-edit">
                                                <form class="formularioContatos" action="services/pessoa.php" method="POST">
                                                    <!-- CAMPOS OCULTOS -->
                                                    <input type="hidden" name="function" value="edit"/>
                                                    <input type="hidden" name="id" value="<?php echo $dados->id ?>"/>
                                                    <input type="hidden" name="tipoUsuario" value="6"/>
                                                    <input type="hidden" name="id_responsavel" value=""/>
                                                    <input type="hidden" name="codigoInterno" value=""/>  
                                                    <input type="hidden" name="nome" value="<?php echo $dados->nome ?>"/>
                                                    <input type="hidden" name="dataNascimento" value="<?php echo formata_padrao_data($dados->dataNascimento) ?>"/>
                                                    <input type="hidden" name="sexo" value="<?php echo $dados->sexo ?>"/>
                                                    <input type="hidden" name="cpf" value="<?php echo $dados->cpf ?>"/>

                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Telefone</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" name="fone" data-mask="00000000000" value="<?php echo $dados->fone ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>

                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Celular</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" name="celular" data-mask="00000000000" value="<?php echo $dados->celular ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>                                        
                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Email</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="email" class="form-control" name="email" value="<?php echo $dados->email ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Nickname</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" id="login" name="login" value="<?php echo $dados->login ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Rua</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" name="rua" value="<?php echo $dados->rua ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Numero</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" name="numero" value="<?php echo $dados->numero ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Complemento</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" name="complemento" value="<?php echo $dados->complemento ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>
                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">Bairro</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" name="bairro" value="<?php echo $dados->bairro ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>  
                                                    <dl class="dl-horizontal">
                                                        <dt class="p-t-10">CEP</dt>
                                                        <dd>
                                                            <div class="fg-line">
                                                                <input type="text" class="form-control" name="cep" value="<?php echo $dados->cep ?>">
                                                            </div>
                                                        </dd>
                                                    </dl>                                        

                                                    <div class="m-t-30">
                                                        <button id="salvar" type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                                        <button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancelar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>                                        
                                        
                                    </div>

                                    <div role="tabpanel" class="tab-pane animated fadeIn" id="tab-2">
                                        <?php
                                        if($alunos != "nenhum"){
                                            foreach ($alunos as $aluno){
                                        ?>
                                        <a class="list-group-item media" href="alunoDetail?i=<?php echo $aluno->id?>">
                                            <div class="pull-left">
                                                <img class="lgi-img" src="fotos/avatar.png" alt="">
                                            </div>
                                        <div class="media-body">
                                            <div class="lgi-heading"><?php echo $aluno->nome ?></div>
                                                <small><strong>Nickname: </strong><?php echo $aluno->login ?></small><br>
                                            </div>
                                        </a>
                                        <?php
                                            }
                                        }else{
                                            echo "Nenhum aluno vinculado";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>  
  
                        </div>
        
                    </div>
                </div>
            </section>
    
        </section>

    <!-- Javascript Libraries -->
    <script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/bower_components/Waves/dist/waves.min.js"></script>
    <script src="vendors/bower_components/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="vendors/bower_components/mediaelement/build/mediaelement-and-player.min.js"></script>
    <script src="vendors/bower_components/moment/min/moment.min.js"></script>
    <script src="vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="vendors/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js"></script>

    <script src="vendors/sparklines/jquery.sparkline.min.js"></script>

    <!-- FLOT CHART JS -->
    <script src="vendors/bower_components/flot/jquery.flot.js"></script>
    <script src="vendors/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.categories.js"></script>
    <script src="vendors/bootstrap-growl/bootstrap-growl.min.js"></script>

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        $(function(){
            
            $("#login").keyup(function () {
                $.ajax({
                    url: "services/pessoa.php",
                    type: 'POST',
                    data: {function: 'buscaPorLogin', login: $("#login").val()},
                    success: function (data) {
                        if(data === "disponivel"){
                            $("#salvar").removeAttr("disabled", "");
                            //notificacao();
                        }else{
                            $("#salvar").attr("disabled", "");
                            notificacao();
                        }
                        
                    }
                });
            });            
            
            $('.formularioInfos').ajaxForm({
                beforeSend: function () {
                    $('.loadingEdit').css({display: "block"});
                },
                success: function () {
                    $('.loadingEdit').css({display: "none"});
                },
                complete: function(result){
                    if(result.responseText === "success"){
                        swal({
                            title: "Atualizado com sucesso",
                            text: "Registro atualizado com sucesso",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function(){
                            location.reload();
                        });   
                    }else{
                        swal({
                            title: "Falha ao atualizar registro",
                            text: result.responseText,
                            type: "error"
                        });                        
                    }
 
                }
            });
            
            $('.formularioContatos').ajaxForm({
                beforeSend: function () {
                    $('.loadingEdit').css({display: "block"});
                },
                success: function () {
                    $('.loadingEdit').css({display: "none"});
                },
                complete: function(result){
                    if(result.responseText === "success"){
                        swal({
                            title: "Atualizado com sucesso",
                            text: "Registro atualizado com sucesso",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function(){
                            location.reload();
                        });   
                    }else{
                        swal({
                            title: "Falha ao atualizar registro",
                            text: result.responseText,
                            type: "error"
                        });                        
                    }
 
                }
            });            
        });
        
        $('.delete').click(function () {    
            swal({
                title: "Tem certeza?",
                text: "O registro será excluído!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, excluir!",
                closeOnConfirm: false
            }).then(function () {
                excl(<?php echo $dados->id ?>);
            });
        });
        
        function excl(id_pessoa){
            $.ajax({
                    type: "POST",
                    data: {i:id_pessoa, function:'remover'},
                    url: "services/pessoa.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Removido com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.href='responsaveis';
                        });                         
                    }                    
                });
        } 
        
            function notificacao(){
                $.growl({
                    icon: 'fa fa-check',
                    title: '',
                    message: 'Este login já está sendo utilizado',
                    url: ''
                },{
                        element: 'body',
                        type: 'danger',
                        allow_dismiss: true,
                        placement: {
                                from: 'top',
                                align: 'right'
                        },
                        offset: {
                            x: 20,
                            y: 85
                        },
                        spacing: 10,
                        z_index: 1031,
                        delay: 2500,
                        timer: 1000,
                        url_target: '_blank',
                        mouse_over: false,
                        animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                        },
                        icon_type: 'class',
                        template: '<div data-growl="container" class="alert" role="alert">' +
                                        '<button type="button" class="close" data-growl="dismiss">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                            '<span class="sr-only">Close</span>' +
                                        '</button>' +
                                        '<span data-growl="icon"></span>' +
                                        '<span data-growl="title"></span>' +
                                        '<span data-growl="message"></span>' +
                                        '<a href="#" data-growl="url"></a>' +
                                    '</div>'
                });
            };        
        
    </script>      

</body>
</html>
