<?php
require_once 'services/manager_session.php';
require_once 'services/curso.php';
require_once 'services/nivel.php';
require_once 'services/matricula.php';
require_once 'services/disciplina.php';
require_once 'services/pessoa.php';
require_once 'services/funcoes.php';
require_once 'services/tipoAvaliacao.php';
require_once 'services/nota.php';

session_start();
ManagerSession::validaAcesso(28);
ManagerSession::setCookie();

if(!empty($_GET)){
    $matricula = listarMatricula($_GET['m']);
    $disciplina = listarDisciplina($_GET['d']);
    $curso_mat = listarCurso($matricula->id_curso);
    $nivel_mat = listarNivel($curso_mat->id_nivel);    
    $aluno = listarPessoa($matricula->id_pessoa);
    $tiposAvaliacao = listarTiposAvaliacao();
    
    if($matricula == "nenhum"){
        echo "<script>location.href='home'</script>";
    }
    
    $md = buscaPorMatriculaDisciplina($matricula->id, $disciplina->id);
    $tiposPrevistos = listarTiposPrevistos($md->id);
    $notas = notaPorMd($md->id);
    
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
    <link href="vendors/bower_components/chosen/chosen.css" rel="stylesheet">
    <link href="vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">     
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
 
                    <div class="card">
                        <a class="list-group-item media" href="alunoDetail?i=<?php echo $aluno->id ?>">
                            <div class="pull-left">
                                <img class="lgi-img" src="fotos/avatar.png" alt="">
                            </div>
                            <div class="media-body">
                            <div class="lgi-heading"><?php echo $aluno->nome ?></div>
                                <small><strong>Curso: </strong><?php echo $matricula->nome_curso." - ".$nivel_mat->nome ?></small><br>    
                                <small><strong>Turma: </strong><?php echo $matricula->nome_turma ?></small><br>
                                <small><strong>Data de início: </strong><?php echo formata_padrao_data($matricula->data_inicio) ?></small><br>
                            </div>
                        </a>                         
                        <div class="card-body">
                                  
                                <ul class="tab-nav tn-justified tn-icon" role="tablist">
                                    <li role="presentation" class="active">
                                        <a class="col-sx-4" href="#tab-1" aria-controls="tab-1" role="tab"
                                           data-toggle="tab">
                                            NOTAS
                                        </a>
                                    </li>
                                </ul>
                                
                                <div class="tab-content p-20">
                                    <div role="tabpanel" class="tab-pane animated fadeIn in active" id="tab-1" style="padding: 30px">

                                        <div class="panel-group" data-collapse-color="black" id="accordionBlack"
                                             role="tablist" aria-multiselectable="true">

                                            <div class="panel panel-collapse">
                                                <div class="panel-heading" role="tab">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordionBlack"
                                                           href="#<?php echo $md->id ?>" aria-expanded="true">
                                                            <?php echo $disciplina->nome ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="<?php echo $md->id ?>" class="collapse in" role="tabpanel">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            
                                                            <?php
                                                            if($notas != "nenhum"){
                                                                foreach ($notas as $nota){
                                                            ?>
                                                            
                                                            <div class="col-sm-2">
                                                                <div class="card">
                                                                    <a href="notaDetail?i=<?php echo $nota->id ?>">
                                                                    <div class="card-header c-white" style="background-color: #0073AA;">
                                                                        <h2 style="color: #fff; font-size: 25px"><?php echo moeda($nota->valor) ?>
                                                                            <small style="color: #fff"><?php echo $nota->tipo_avaliacao_nome ?></small>
                                                                        </h2>                                                                       
                                                                    </div>
                                                                    </a>
                                                                    <div class="card-body card-padding bgm-white" style="padding: 15px">
                                                                        <small class="f-11">Data da avaliacao: <?php echo formata_padrao_data($nota->data_avaliacao) ?></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <?php }
                                                            }else{
                                                                echo "<p style='margin-left:15px'>nenhuma nota</p>";
                                                            }
                                                            ?> 
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body" style="margin-top: 30px">
                                        <a href="javascript:history.back()" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                                        <a data-toggle="modal" href="#nota" id="salvar" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Lançar nota</a>
                                    </div>

                                    
                                    
                                </div>
                                
                                <div class="tab-content p-20">
                                    <div role="tabpanel" class="tab-pane animated fadeIn" id="tab-2">
                                        
                                    </div>
                                </div>                                
                                
                            </div>
                            
                    </div>
            </div>              
        </section>
        <div class="modal fade" id="nota" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Lançar Nota</h4>
                    </div>

                    <form class="formularioNota" action="services/nota.php" method="POST">
                        <input type="hidden" name="function" value="nova"/> 
                        <input type="hidden" name="pessoa" value="<?php echo $_SESSION['UsuarioID']?>"/>
                        <div class="card">
                            <div class="card-body card-padding">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="fg-line form-group">
                                            <label>Valor</label>
                                            <input type="text" class="form-control input-sm" id="valor" name="valor" required="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">  
                                        <div class="fg-line form-group">
                                            <label>Disciplina</label><br>
                                            <select class="selectpicker" style="padding: 6px; border: none; width: 100%" id="md" name="md">
                                                <option style="padding: 10px" value="<?php echo $md->id ?>"><?php echo $disciplina->nome ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="fg-line form-group">
                                            <label>Tipo de avaliação</label><br>
                                            <select class="selectpicker" style="padding: 6px; border: none; width: 100%" id="tipos" name="tipoAvaliacao">
                                                <option selected="" disabled="" value="">SELECIONE</option>
                                                    <?php
                                                    if($tiposPrevistos != "nenhum"){
                                                    foreach ($tiposPrevistos as $tipo) {
                                                        ?>
                                                            <option style="padding: 10px" value="<?php echo $tipo->id ?>"><?php echo $tipo->descricao ?></option>
                                                        <?php
                                                    }
                                                    }else{
                                                        echo 'Todas as notas previstas já foram lançadas';
                                                    }
                                                    ?>                                                
                                            </select>
                                        </div>
                                    </div>                                                                

                                    <div class="col-sm-6">  
                                        <div class="fg-line form-group">
                                            <label>Data da avaliação</label><br>
                                            <input name="dataAvaliacao" type='text' data-toggle="datepicker" class="form-control dataAvaliacao">
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
    <script src="vendors/bower_components/chosen/chosen.jquery.js"></script>
    <script src="vendors/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    <script src="vendors/bower_components/chosen/chosen.jquery.js"></script>
    <script src="vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>      
    <script src="js/datepicker.js"></script>
    <script src="js/datepicker.pt-BR.js"></script>   
    <script src="vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]>
        <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
    <![endif]-->

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        $(function(){
            
            $('.dataAvaliacao').datepicker({
              autoHide: true,
              zIndex: 2048,
              language: 'pt-BR'
            });
            
            $('.formularioNota').ajaxForm({
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
        
        function buscaTiposPrevistos(){
            $.ajax({
               url: "services/tipoAvaliacao.php",
               type: 'POST',
               data:{function: 'listarTiposParaLancamento', md: $("#md").val()},
               success:function(data){
                   $("#tipos").html(data);
               }
            });
        }         
        
        $('#valor').mask('00,00', {reverse: true});
        
    </script>      

</body>
</html>
