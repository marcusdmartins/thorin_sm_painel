<?php
require_once 'services/manager_session.php';
require_once 'services/sala.php';
session_start();
ManagerSession::validaAcesso(22);
ManagerSession::setCookie();

if(!empty($_GET)){
    $dados = listarSala($_GET['i']);
    if($dados == "nenhum"){
        echo "<script>location.href='home'</script>";
    }
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
        <section id="content" style="margin-top: -15px">
           <div class="container">
               <form class="formularioNivel" action="services/posts/sala_posts.php" method="POST">
                    <input type="hidden" name="function" value="novo"/>
                    <div class="card">
                        <div class="card-header">
                            <h2>Sala</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <p><?php echo $dados->nome ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="preloader loadingCliente" style="display: none; float: left; padding-top: 5px">
                            <svg class="pl-circular" viewBox="25 25 50 50">
                            <circle class="plc-path" cx="50" cy="50" r="20"/>
                            </svg>
                        </div>                    
                    <div class="card-body">
                        <a href="salas" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                        <a style="float: right; margin: 5px" class="btn bgm-red btn-icon-text delete" id="delete"><i class="zmdi zmdi-delete"></i> Excluir</a>
                        <a data-toggle="modal" href="#edit" style="float: right; margin: 5px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-edit"></i> Editar</a>
                    </div>
                </form>                
            </div>              
        </section>
        
        <div class="modal fade" id="edit" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">EDITAR DADOS</h4>
                    </div>

                    <form class="formularioNivel" action="services/sala.php" method="POST">
                        <input type="hidden" name="function" value="edit"/> 
                        <input type="hidden" name="id" value="<?php echo $dados->id ?>"/>
                        <div class="card">
                            <div class="card-body card-padding">
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="fg-line form-group">
                                            <input type="text" class="form-control input-sm" name="nome" placeholder="Nome" required="" value="<?php echo $dados->nome ?>">                                                       
                                        </div>
                                    </div>

                                    <div class="col-sm-6">               
                                        <div class="preloader loadingEdit" style="display: none; float: left; padding-top: 5px">
                                            <svg class="pl-circular" viewBox="25 25 50 50">
                                            <circle class="plc-path" cx="50" cy="50" r="20"/>
                                            </svg>
                                        </div>    
                                    </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-link">Salvar</button>
                                            <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
                                        </div>                                    

                                </div>

                            </div>
                        </div>

                    </form> 

                </div>
            </div>
        </div>         
        
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


    <script src="vendors/sparklines/jquery.sparkline.min.js"></script>

    <!-- FLOT CHART JS -->
    <script src="vendors/bower_components/flot/jquery.flot.js"></script>
    <script src="vendors/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.categories.js"></script>

    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]>
        <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
    <![endif]-->

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        $(function(){
            $('.formularioNivel').ajaxForm({
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
                            title: "Falha ao atualizar",
                            
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
        
        function excl(id_sala){
            $.ajax({
                    type: "POST",
                    data: {i:id_sala, function:'remover'},
                    url: "services/sala.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Removido com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.href='salas';
                        });                         
                        
                        
                    }                    
                });
        }   
        
    </script>      

</body>
</html>
