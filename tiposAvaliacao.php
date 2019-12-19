<?php
require_once 'services/manager_session.php';
require_once 'services/tipoAvaliacao.php';
session_start();
ManagerSession::validaAcesso(23);
ManagerSession::setCookie();

$tipos = listarTiposAvaliacao();

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
    
    <style>
        
        .icons-tab{
            width: 20px; 
            margin-top: -5px;
        }
        
    </style>    

</head>
<body>
    <?php include("topo.php") ?>

    <section id="main">
        <?php include ("menu.php") ?>

        <section id="content" style="margin-top: -15px">
           <div class="container">
                    <div class="card">
                        <ul class="tab-nav tn-justified tn-icon" role="tablist" style="padding-top: 15px">
                            <li role="presentation" class="active">
                                <a class="col-sx-4" href="#tab-1" aria-controls="tab-1" role="tab"
                                   data-toggle="tab">
                                    <img class="icons-tab" style="width: 25px; margin-right: 10px" src="img/icones/calendario_notas.png">  Calendário de Notas
                                </a>
                            </li>
                            <li role="presentation">
                                <a class="col-xs-4" href="#tab-2" aria-controls="tab-2" role="tab"
                                   data-toggle="tab">
                                    <img class="icons-tab" style="margin-right: 10px" src="img/icones/media.png">  Médias
                                </a>
                            </li>
                        </ul>
                        
                        <div class="tab-content p-20">
                            <div role="tabpanel" class="tab-pane animated fadeIn in active" id="tab-1" style="padding: 20px; padding-bottom: 30px">
                                <div class="list-group">
                                        <?php
                                                if($tipos != "nenhum"){
                                                        foreach ($tipos as $tipo){
                                        ?>
                                        <a class="list-group-item media" href="tipoAvaliacaoDetail?i=<?php echo $tipo->id ?>">
                                                <div class="pull-left">
                                                        <img class="lgi-img" src="img/curso.png" alt="">
                                                </div>
                                                <div class="media-body">
                                                        <div class="lgi-heading"><?php echo $tipo->descricao ?></div>
                                                </div>
                                        </a>
                                        <?php
                                                        }
                                                }else{
                                                        echo "Nenhum tipo cadastrado";
                                                }
                                        ?>
                                </div>
                                    <div class="card-body">
                                        <a href="tipoAvaliacaoNovo" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Novo</a>
                                    </div>                                
                            </div>
                            
                            <div role="tabpanel" class="tab-pane animated fadeIn" id="tab-2" style="padding: 20px; padding-bottom: 30px">
                                <div class="card-body">
                                    <a href="tipoAvaliacaoNovo" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Nova</a>
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
            $('.formularioTipoAvaliacao').ajaxForm({
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
                            text: "Registro inserido com sucesso",
                            type: "success"
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
