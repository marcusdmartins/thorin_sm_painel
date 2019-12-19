<?php
require_once 'services/manager_session.php';
require_once 'services/pessoa.php';
session_start();
ManagerSession::validaAcesso(1); //INDICA A SUBROTINA NA QUAL A PÁGINA ESTÁ VINCULADA
ManagerSession::setCookie();

$responsaveis = listarPessoasPorTipo('6');

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
    <link href="vendors/bower_components/chosen/chosen.css" rel="stylesheet">   
    <link href="vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">    
    <!-- CSS -->
    <link href="css/app_1.min.css" rel="stylesheet">
    <link href="css/app_2.min.css" rel="stylesheet">

</head>
<body>
    <?php include("topo.php") ?>

    <section id="main">
        <?php include ("menu.php") ?>

        <section id="content" style="margin-top: -15px">
           <div class="container">
               <form class="formularioAluno" action="services/pessoa.php" method="POST">
                    <input type="hidden" name="function" value="nova"/>
                    <input type="hidden" name="tipoUsuario" value="5"/>
                    <input type="hidden" name="codigoInterno" value=""/>
                    <div class="card">
                        <div class="card-header">
                            <h2>Novo Aluno</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Nome</label>
                                        <input type="text" class="form-control input-sm" name="nome" placeholder="Nome" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control input-sm" name="email" placeholder="Email" required="">
                                    </div>
                                </div>    
                                
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Data de Nascimento</label>
                                        <input type="text" class="form-control input-sm" data-mask="00/00/0000" name="dataNascimento" placeholder="Data de nascimento" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">  
                                    <div class="fg-line form-group">
                                        <label>Sexo</label><br>
                                        <select class="chosen" placeholder="Selecione o turno" name="sexo">
                                                <option disabled="" selected="" value="">SELECIONE</option>
                                                <option value="f">Feminino</option>
                                                <option value="m">Masculino</option>
                                        </select>
                                    </div>
                                </div>                                
                                
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>CPF</label>
                                        <input type="text" class="form-control input-sm" data-mask="000.000.000-00" name="cpf" placeholder="CPF">
                                    </div>
                                </div>                                 

                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Login</label>
                                        <input type="text" class="form-control input-sm" id="login" name="login" placeholder="Login" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Senha</label>
                                        <input type="password" class="form-control input-sm" name="senha" placeholder="Senha" required="">
                                    </div>
                                </div>                                
                                
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Telefone</label>
                                        <input type="text" class="form-control input-sm" data-mask="000000000000" name="fone" placeholder="Telefone" required="">
                                    </div>
                                </div> 

                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Celular</label>
                                        <input type="text" class="form-control input-sm" data-mask="000000000000" name="celular" placeholder="Celular" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Responsável</label><br>
                                        <select class="chosen" data-placeholder="Selecione o responsavel" name="id_responsavel" id="responsavel" onchange="buscaEnderecoResponsavel()">
                                            <!--<optgroup label="RESPONSAVEIS"> -->
                                                <option disabled="" selected="" value="">SELECIONE</option>
                                                <?php
                                                if($responsaveis != "nenhum"){
                                                    foreach ($responsaveis as $responsavel) {
                                                ?>
                                                    <option value="<?php echo $responsavel->id ?>"><?php echo $responsavel->nome." - ".$responsavel->cpf ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>                                
                                
                            </div>
                        </div>
                        
                        <div class="card-header">
                            <h2>Endereço</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>CEP</label>
                                        <input type="text" class="form-control input-sm" data-mask="00000-000" id="cep" name="cep" placeholder="CEP" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Rua</label>
                                        <input type="text" class="form-control input-sm" name="rua" id="rua" placeholder="Rua" required="">
                                    </div>
                                </div>    
                                
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Número</label>
                                        <input type="text" class="form-control input-sm" name="numero" id="numero" placeholder="Numero" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Complemento</label>
                                        <input type="text" class="form-control input-sm" name="complemento" id="complemento" placeholder="Complemento" required="">
                                    </div>
                                </div> 

                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Bairro</label>
                                        <input type="text" class="form-control input-sm" name="bairro" id="bairro" placeholder="Bairro" required="">
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                   <p style="font-size: 11px" id="info_login"></p>
                    <div class="card-body">
                        <a href="alunos" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                        <button type="submit" id="salvar" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Salvar</button>
                    
                    <!-- SPINEER DE LOADING-->    
                    <div class="preloader loadingCliente" style="display: none">
                        <svg class="pl-circular" viewBox="25 25 50 50">
                        <circle class="plc-path" cx="50" cy="50" r="20"/>
                        </svg>
                    </div> 
                    </div>
                </form>

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
    <script src="vendors/bower_components/chosen/chosen.jquery.js"></script>
    <script src="vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>    

    <script src="vendors/sparklines/jquery.sparkline.min.js"></script>

    <!-- FLOT CHART JS -->
    <script src="vendors/bower_components/flot/jquery.flot.js"></script>
    <script src="vendors/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.categories.js"></script>
    <script src="vendors/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js"></script>

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
                            $("#info_login").html("Login disponivel");
                            $("#salvar").removeAttr("disabled", "");
                        }else{
                            $("#salvar").attr("disabled", "");
                            $("#info_login").html("Este login já está sendo utilizado");
                        }
                        
                    }
                });
            });
            
            $('.formularioAluno').ajaxForm({
                beforeSend: function () {
                    $('.loadingCliente').css({display: "block"});
                },
                success: function () {
                    $('.loadingCliente').css({display: "none"});
                },
                complete: function(result){
                    if(result.responseText !== "error"){
                        swal({
                            title: "Salvo com sucesso",
                            text: "Registro inserido com sucesso",
                            type: "success"
                        }).then(function () {
                            location.href='alunoDetail?i='+result.responseText;
                        });   
                        
                    }else{
                        swal({
                            title: "Falha ao inserir",
                            text: result.responseText,
                            type: "error"
                        });                        
                    }
                }
            });
        });
        
        function buscaEnderecoResponsavel(){
            $.ajax({
               url: "services/pessoa.php",
               type: 'POST',
               data:{function: 'listarPessoa', id: $("#responsavel").val()},
               success:function(data){
                   var obj = JSON.parse(data);
                   $("#cep").val(obj.cep);
                   $("#rua").val(obj.rua);
                   $("#numero").val(obj.numero);
                   $("#complemento").val(obj.complemento);
                   $("#bairro").val(obj.bairro);
                   //alert(obj.rua);
               }
            });
        };        
        
    </script>      

</body>
</html>
