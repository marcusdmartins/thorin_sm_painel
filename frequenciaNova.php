<?php
require_once 'services/manager_session.php';
require_once 'services/disciplinaProfessor.php';
require_once 'services/pessoa.php';
require_once 'services/turma.php';
require_once 'services/matricula.php';
session_start();
ManagerSession::validaAcesso(28);
ManagerSession::setCookie();

if(!empty($_GET)){
    $disc_professor = listaDisciplinaProfessor($_GET['i']);
    $dados = listarTurma($disc_professor->id_turma);
    $matriculas_alunos = matriculasRegularesPorTurma($dados->id);
    $data_atual = date("d/m/Y");
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
    <link href="vendors/bower_components/chosen/chosen.css" rel="stylesheet"> 
    <link href="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <link href="vendors/bower_components/mediaelement/build/mediaelementplayer.css" rel="stylesheet">
    <link href="vendors/summernote/dist/summernote.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet"> 
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
               <form class="formFrequencia" method="POST" action="services/frequencia.php">
                   <input type="hidden" id="function" name="function" value="nova"/>
                   <input type="hidden" id="dp" name="dp" value="<?php echo $disc_professor->id ?>"/>
                   <input type="hidden" id="professor_id" name="professor_id" value="<?php echo $_SESSION['UsuarioID'] ?>"/>
                   <input type="hidden" id="id_turma" name="id_turma" value="<?php echo $dados->id ?>"/>
                   
                    <div class="card">
                        <div class="card-header">
                            <h2>Lista de frequencia</h2>
                        </div>   
                        
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Data</label>
                                        <input id="data" name="data" type="text" value="<?php echo $data_atual ?>" class="form-control input-sm dataAula" data-toggle="datepicker" name="data" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="preloader loadingEdit" style="display: none; float: left; padding-top: 5px">
                                        <svg class="pl-circular" viewBox="25 25 50 50">
                                        <circle class="plc-path" cx="50" cy="50" r="20"/>
                                        </svg>
                                    </div>    
                                </div>

                            </div>

                        </div>
                    </div>
                   
                    <div class="card">
                        <div class="list-group lg-odd-black">
                            <div class="action-header clearfix">
                                <div class="ah-label hidden-xs">Alunos</div>

                                <div class="ah-search">
                                    <input type="text" placeholder="Buscar aluno..." class="ahs-input">
                                    <i class="ahs-close" data-ma-action="action-header-close">&times;</i>
                                </div>

                                <ul class="actions">
                                    <li>
                                        <a href="" data-ma-action="action-header-open">
                                            <i class="zmdi zmdi-search"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <?php
                            
                            if($matriculas_alunos != "nenhum"){
                                foreach ($matriculas_alunos as $matricula){
                                    $aluno = listarPessoa($matricula->id_pessoa);
                            ?>
                            
                            <div class="list-group-item media">
                                <div class="checkbox pull-left">
                                    <label>
                                        <input type="checkbox" class="matricula" id="<?php echo $matricula->id_pessoa ?>" name="alunos[]" value="<?php echo $matricula->id_pessoa ?>">
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                                <div class="pull-left">
                                    <img class="lgi-img" src="fotos/avatar.png" alt="">
                                </div>
                                
                                <div style="cursor: pointer" class="media-body" onclick="seleciona(<?php echo $matricula->id_pessoa ?>)" >
                                    <div class="lgi-heading"><?php echo $aluno->nome ?></div>
                                    <small class="lgi-text"><?php echo $aluno->login ?></small>
                                </div>
                            </div>
                            
                            <?php
                                }
                            }else{
                                echo "<p style='margin-left:30px'>nenhum aluno</p>";
                            }
                            ?>

                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link">Salvar</button>
                            <a href="frequenciaDisc?i=<?php echo $disc_professor->id ?>" class="btn btn-link" data-dismiss="modal">Cancelar</a>
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
    <script src="vendors/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    <script src="vendors/bower_components/chosen/chosen.jquery.js"></script>

    <script src="vendors/sparklines/jquery.sparkline.min.js"></script>

    <!-- FLOT CHART JS -->
    <script src="vendors/bower_components/flot/jquery.flot.js"></script>
    <script src="vendors/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.categories.js"></script>
    <script src="vendors/summernote/dist/summernote-updated.min.js"></script>
    <script src="vendors/fileinput/fileinput.min.js"></script>
    <script src="js/datepicker.js"></script>
    <script src="js/datepicker.pt-BR.js"></script>       

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        $(function(){      
            $('.dataAula').datepicker({
              autoHide: true,
              zIndex: 2048,
              language: 'pt-BR'
            }); 
            
            $('.formFrequencia').ajaxForm({
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
                        }).then(function () {
                            location.href='frequenciaDisc?i=<?php echo $disc_professor->id ?>';
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
        
        function seleciona(id){
            
            if($('#'+id).prop("checked")){
              $('#'+id).prop("checked", false);  
            }else{
                $('#'+id).prop("checked", true); 
            }
        }
       
    </script>      

</body>
</html>
