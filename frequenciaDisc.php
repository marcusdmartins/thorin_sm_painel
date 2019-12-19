<?php
require_once 'services/manager_session.php';
require_once 'services/frequencia.php';
require_once 'services/disciplinaProfessor.php';
require_once 'services/funcoes.php';
session_start();
ManagerSession::validaAcesso(28);
ManagerSession::setCookie();

if(!empty($_GET)){
    $dados = frequenciaPorDP($_GET['i']);
    $disc_professor = listaDisciplinaProfessor($_GET['i']);

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
               <form class="formularioCurso" action="services/curso.php" method="POST">
                    <input type="hidden" name="function" value="novo"/>
                    <div class="card">
                        <div class="card-header">
                            <h2>Frequencias</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-12">
                                <div class="list-group">
                                    
                                    <?php
                                        if($dados != "nenhum"){
                                            foreach ($dados as $dado){
                                    ?>
                                    
                                    <a class="list-group-item media" href="frequenciaDetail?i=<?php echo $dado->id ?>">
                                        <div class="pull-left">
                                            <img class="lgi-img" src="img/curso.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading"><?php echo formata_padrao_data($dado->data) ?></div>
                                        </div>
                                    </a>
                                    
                                    <?php
                                            }
                                        }else{
                                            echo "Nenhuma frequencia";
                                        }
                                    ?>
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
                        <a href="profTurmaDetail?i=<?php echo $disc_professor->id ?>" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                        <a href="frequenciaNova?i=<?php echo $disc_professor->id ?>" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Nova</a>
                    </div>
                </form>
               
                <div class="modal fade" id="plan" role="dialog" aria-hidden="true" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">NOVO PLANO</h4>
                            </div>

                            <form class="formularioPlan" action="services/planejamento.php" method="POST">
                                <input type="hidden" name="function" value="novo"/> 
                                <input type="hidden" name="dp" value="<?php echo $disc_professor->id ?>"/>
                                <input type="hidden" name="professor_id" value="<?php echo $_SESSION['UsuarioID'] ?>"/>

                                <div class="card">
                                    <div class="card-body card-padding">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="fg-line form-group">
                                                    <label>Título</label>
                                                    <input id="valor" type="text" class="form-control input-sm" name="titulo" required="">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="fg-line form-group">
                                                    <label>Texto</label>
                                                    <input id="valor" type="text" class="form-control input-sm" name="texto" required="">
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
            $('.formularioPlan').ajaxForm({
                beforeSend: function () {
                    $('.loadingCliente').css({display: "block"});
                },
                success: function () {
                    $('.loadingCliente').css({display: "none"});
                },
                complete: function(result){ 
                    if(result.responseText === "success"){
                        swal({
                            title: "Salvo com sucesso",
                            text: "Registro atualizado com sucesso",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function(){
                            location.reload();
                        }); 
                    }else{
                        swal({
                            title: "Falha ao inserir",
                            text: "Falha ao inserir registro",
                            type: "error"
                        });                        
                    }
 
                }
            });
        });
    </script>      

</body>
</html>
