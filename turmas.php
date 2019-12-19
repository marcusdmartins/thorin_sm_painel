<?php
require_once 'services/manager_session.php';
require_once 'services/turma.php';
require_once 'services/curso.php';
require_once 'services/sala.php';

session_start();
ManagerSession::validaAcesso(21);
ManagerSession::setCookie();

$turmas = listarTurmas();
$cursos = listarCursos();
$salas = listarSalas();

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
                    <div class="card">
                        <div class="card-header">
                            <h2>Turmas</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">

                                <div class="col-sm-3">
                                    <div class="fg-line form-group">

                                        <select class="selectpicker" data-placeholder="Selecione o curso" name="id_curso" id="curso">
                                            <?php if($cursos != "nenhum"){
                                                    foreach ($cursos as $curso){
                                            ?>
                                                <option value="<?php echo $curso->id ?>"><?php echo $curso->nome." - ".$curso->nome_nivel ?></option>
                                            <?php
                                            }}
                                            ?>

                                        </select>
                                    </div>
                                </div> 

                                <div class="col-sm-2">
                                    <div class="fg-line form-group">
                                        <button id="buscaBtn" onclick="buscaPorCurso()" style="float: left" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-search"></i> Buscar</button>
                                    </div>
                                </div>                            
                            </div>                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="list-group" id="resultados">
                                    <!-- RESULTADO DA BUSCA -->
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
                        <a href="turmaNova" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Nova</a>
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
    <script src="vendors/bower_components/chosen/chosen.jquery.js"></script>
    <script src="vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>  
    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]>
        <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
    <![endif]-->

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        $(function(){
            $("#busca").keyup(function () {
                $.ajax({
                    url: "services/turma.php",
                    type: 'POST',
                    data: {function: 'buscaInstTurma', busca: $("#busca").val(), id_curso: $("#curso").val()},
                    success: function (data) {
                        $("#resultados").html(data);
                    }
                });
            });
        });
        
        function buscaPorCurso(){
                $.ajax({
                    url: "services/turma.php",
                    type: 'POST',
                    data: {function: 'buscaPorCurso', id_curso: $("#curso").val()},
                    success: function (data) {
                        $("#resultados").html(data);
                    }
                });
        };         
    </script>      

</body>
</html>
