<?php
require_once 'services/manager_session.php';
require_once 'services/turma.php';
require_once 'services/curso.php';
require_once 'services/sala.php';
require_once 'services/nivel.php';
require_once 'services/disciplinaProfessor.php';
require_once 'services/pessoa.php';

session_start();
ManagerSession::validaAcesso(30);
ManagerSession::setCookie();

$turmas = listarTurmas();
$cursos = listarCursos();
$salas = listarSalas();
$professores = listarPessoasPorTipo('4');

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
                            <h2>Disciplina x Professor</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">  
                                    <div class="fg-line form-group">
                                        <label>Curso</label><br>
                                        <select style="padding: 6px; border: none; width: 100%" id="curso" name="id_curso" onchange="buscaTurmas()">
                                            <option selected="" disabled="" value="">SELECIONE</option>
                                                <?php
                                                if($cursos != "nenhum"){
                                                foreach ($cursos as $curso) {
                                                    $nivel_select = listarNivel($curso->id_nivel);
                                                    ?>
                                            <option style="padding: 10px" value="<?php echo $curso->id ?>"><?php echo $curso->nome." - ".$nivel_select->nome ?></option>
                                                    <?php
                                                }
                                                }else{
                                                    echo 'Nenhum Curso';
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">  
                                    <div class="fg-line form-group">
                                        <label>Turma</label><br>
                                        <select style="padding: 6px; border: none; width: 100%" id="turma" name="id_turma" onchange="buscaPorTurma()">
                                            <option selected="" disabled="" value="">SELECIONE</option>
                                        </select>
                                    </div>
                                </div>

<!--                            <div class="col-sm-4">
                                    <div class="fg-line form-group" style="margin-top: 22px">
                                        <button id="buscaBtn" onclick="buscaPorTurma()" style="float: left" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-search"></i> Buscar</button>
                                    </div>
                                </div>                            -->
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
                        <a href="#novaDP" data-toggle="modal" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-accounts-add"></i> Relacionar professor</a>
                    </div>
            </div>
            
            <div class="modal fade" id="novaDP" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Disciplina x Professor</h4>
                        </div>

                        <form class="formularioTurma" action="services/disciplinaProfessor.php" method="POST">
                            <input type="hidden" name="function" value="nova"/> 
                            <div class="card">
                                <div class="card-body card-padding">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="fg-line form-group">
                                                <label>Professor</label><br>
                                                <select class="chosen" data-placeholder="Selecione o responsavel" name="id_professor" id="professor1">
                                                    <!--<optgroup label="RESPONSAVEIS"> -->
                                                        <option disabled="" selected="" value="">SELECIONE</option>
                                                        <?php
                                                        if($professores != "nenhum"){
                                                            foreach ($professores as $professor) {
                                                        ?>
                                                            <option value="<?php echo $professor->id ?>"><?php echo $professor->nome." - ".$professor->cpf ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">  
                                            <div class="fg-line form-group">
                                                <label>Curso</label><br>
                                                <select style="padding: 6px; border: none; width: 100%" id="curso1" name="id_curso" onchange="buscaTurmas1()">
                                                    <option selected="" disabled="" value="null">SELECIONE</option>
                                                        <?php
                                                        if($cursos != "nenhum"){
                                                        foreach ($cursos as $curso1) {
                                                            $nivel_select1 = listarNivel($curso1->id_nivel);
                                                            ?>
                                                    <option style="padding: 10px" value="<?php echo $curso1->id ?>"><?php echo $curso1->nome." - ".$nivel_select1->nome ?></option>
                                                            <?php
                                                        }
                                                        }else{
                                                            echo 'Nenhum Curso';
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">  
                                            <div class="fg-line form-group">
                                                <label>Turma</label><br>
                                                <select style="padding: 6px; border: none; width: 100%" id="turmas1" name="turma">
                                                    <option selected="" disabled="" value="">SELECIONE</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">  
                                            <div class="fg-line form-group">
                                                <label>Disciplina</label><br>
                                                <select style="padding: 6px; border: none; width: 100%" id="disciplinas1" name="disc">
                                                    <option selected="" disabled="" value="">SELECIONE</option>
                                                </select>
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
                                            <button id="salvar1" type="submit" class="btn btn-link">Salvar</button>
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
            
            $('.formularioTurma').ajaxForm({
                beforeSend: function () {
                    $('.loadingEdit').css({display: "block"});
                },
                success: function () {
                    $('.loadingEdit').css({display: "none"});
                },
                complete: function(result){
                    if(result.responseText === "success"){
                        swal({
                            title: "Salvo com sucesso",
                            text: "Turma inserida com sucesso",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function(){
                            location.reload();
                        });   
                    }else if(result.responseText === "incompleto"){
                        swal({
                            title: "Dados incompletos",
                            text: "Por favor, selecione um Professor e uma Turma",
                            type: "warning"
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
        
        function buscaPorTurma(){
            $.ajax({
                url: "services/disciplinaProfessor.php",
                type: 'POST',
                data: {function: 'buscaPorTurma', id_turma: $("#turma").val()},
                success: function (data) {
                    $("#resultados").html(data);
                }
            });
        }; 
        
        function buscaTurmas(){
            $.ajax({
               url: "services/turma.php",
               type: 'POST',
               data:{function: 'buscaPorCursoSelect', id_curso: $("#curso").val()},
               success:function(data){
                   $("#turma").html(data);
                   buscaPorTurma();
               }
            });
        } 
        
        function buscaTurmas1(){
            $.ajax({
               url: "services/turma.php",
               type: 'POST',
               data:{function: 'buscaPorCursoSelect', id_curso: $("#curso1").val()},
               success:function(data){
                   $("#turmas1").html(data);
               }
            });
            
            $.ajax({
               url: "services/disciplina.php",
               type: 'POST',
               data:{function: 'buscaPorCursoSelect', id_curso: $("#curso1").val()},
               success:function(data){
                   $("#disciplinas1").html(data);
                   
                   if($("#disciplinas1").val() === ""){
                        $("#salvar1").attr("disabled", "");
                   }else{
                      $("#salvar1").removeAttr("disabled"); 
                   }
               }
            });             
            
        }         
    </script>      

</body>
</html>
