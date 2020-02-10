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
require_once 'services/frequencia.php';
require_once 'services/media.php';

session_start();
ManagerSession::dois_acessos(1, 2);
ManagerSession::setCookie();

if (!empty($_GET)) {
    $matricula = listarMatricula($_GET['i']);
    $curso_mat = listarCurso($matricula->id_curso);
    $nivel_mat = listarNivel($curso_mat->id_nivel);
    $aluno = listarPessoa($matricula->id_pessoa);
    $tiposAvaliacao = listarTiposAvaliacao();

    if ($matricula == "nenhum") {
        echo "<script>location.href='home'</script>";
    }

    $matriculasDisciplinas = disciplinasPorMatricula($matricula->id);
} else {
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
                    <div class="card-body">

                        <a class="list-group-item media" href="alunoDetail?i=<?php echo $aluno->id ?>">
                            <div class="pull-left">
                                <img class="lgi-img" src="fotos/avatar.png" alt="">
                            </div>
                            <div class="media-body">
                                <div class="lgi-heading"><?php echo $aluno->nome ?></div>
                                <small><strong>Curso: </strong><?php echo $matricula->nome_curso . " - " . $nivel_mat->nome ?></small><br>    
                                <small><strong>Turma: </strong><?php echo $matricula->nome_turma ?></small><br>
                                <small><strong>Data de início: </strong><?php echo formata_padrao_data($matricula->data_inicio) ?></small><br>
                            </div>
                        </a>                       

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <ul class="tab-nav tn-justified tn-icon" role="tablist" style="padding-top: 15px">
                            <li role="presentation" class="active">
                                <a class="col-sx-4" href="#tab-1" aria-controls="tab-1" role="tab"
                                   data-toggle="tab">
                                    <img class="icons-tab" style="width: 25px" src="img/icones/nota.png">  Disciplinas
                                </a>
                            </li>
                            <li role="presentation">
                                <a class="col-xs-4" href="#tab-2" aria-controls="tab-2" role="tab"
                                   data-toggle="tab">
                                    <img class="icons-tab" src="img/icones/media.png">  Frequencia
                                </a>
                            </li>
                            <li role="presentation">
                                <a class="col-xs-4" href="#tab-3" aria-controls="tab-3" role="tab"
                                   data-toggle="tab">
                                    <img class="icons-tab" style="width: 45px" src="img/icones/ranking.png">  Ranking
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-20">
                            <div role="tabpanel" class="tab-pane animated fadeIn in active" id="tab-1" style="padding: 20px; padding-bottom: 30px">
                                <div class="panel-group" data-collapse-color="black" id="accordionBlack"
                                     role="tablist" aria-multiselectable="true">

                                    <?php
                                    foreach ($matriculasDisciplinas as $matriculaDisciplina) {
                                        $disciplina = listarDisciplina($matriculaDisciplina->disc_id);
                                        $notas = notaPorMd($matriculaDisciplina->id);
                                        $medias = buscaMediasPorMD($matriculaDisciplina->id);
                                        ?>

                                        <div class="panel panel-collapse">
                                            <div class="panel-heading" role="tab">
                                                <h2 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordionBlack"
                                                       href="#<?php echo $matriculaDisciplina->id ?>" aria-expanded="true">
                                                        <span style="font-size: 15px; text-transform: uppercase; font-weight: 600"><?php echo $disciplina->nome ?></span>
                                                    </a>
                                                </h2>
                                            </div>
                                            <div id="<?php echo $matriculaDisciplina->id ?>" class="collapse" role="tabpanel">
                                                <div class="panel-body" style="background-color: #f9f9f9">
                                                    <?php
                                                    if ($notas != "nenhum") {
                                                        ?>
                                                        <div class="row" style="padding: 10px">
                                                            <div class="col-sm-8">
                                                                <div class="card">
                                                                    <div class="card-body m-t-0">
                                                                        <table class="table table-inner table-vmiddle">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Calendário de notas</th>
                                                                                    <th style="width: 60px">Nota</th>
                                                                                </tr>
                                                                            </thead>                                                                            
                                                                            <tbody>
                                                                                <?php
                                                                                foreach ($notas as $nota) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?php echo $nota->tipo_avaliacao_nome ?></td>
                                                                                        <td class="f-500 c-cyan"><?php echo moeda($nota->valor) ?></td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                        <!-- <div id="recent-items-chart" class="flot-chart"></div>-->
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <?php
                                                                if ($medias != "nenhum") {
                                                                    ?>
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h2>Médias </h2>
                                                                        </div>

                                                                        <div class="card-body">
                                                                            <div class="list-group">
                                                                                <?php
                                                                                foreach ($medias as $media) {

                                                                                    if ($media->valor < $media->corte) {
                                                                                        $cor_tag = "bgm-red";
                                                                                    } else {
                                                                                        $cor_tag = "bgm-green";
                                                                                    }
                                                                                    ?>
                                                                                    <div class="list-group-item media">
                                                                                        <div class="pull-left">
                                                                                            <div class="event-date <?php echo $cor_tag ?>">
                                                                                                <span class="ed-day" style="padding: 5px; font-weight: 600"><?php echo moeda($media->valor) ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="media-body">
                                                                                            <div class="lgi-heading"><?php echo $media->nome ?></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?> 

                                                            </div>                                                                
                                                        </div>
                                                        <?php
                                                    } else {
                                                        echo "Nenhuma nota lançada";
                                                    }
                                                    ?>    
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="card-body" style="margin-top: 30px; margin-bottom: 30px">
                                    <a data-toggle="modal" href="#recp">Lançar Recuperação</a>
                                    <a data-toggle="modal" href="#nota" id="salvar" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Lançar nota</a>
                                </div>                                
                            </div>

                            <div role="tabpanel" class="tab-pane animated fadeIn" id="tab-2">

                                <table class="table table-inner table-vmiddle">
                                    <thead>
                                        <tr>
                                            <th>Disciplina</th>
                                            <th style="width: 60px">Faltas</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($matriculasDisciplinas as $md1) {
                                            $disciplina1 = listarDisciplina($md1->disc_id);
                                            $matriculaAluno = listarMatricula($md1->id_matricula);
                                            $faltas = frequenciaAlunoDisciplina($disciplina1->id, $matriculaAluno->id_pessoa, "f");
                                            ?>                                            

                                            <tr>
                                                <td><?php echo $disciplina1->nome ?></td>
                                                <td class="f-500 c-red"><a class="c-red" data-toggle="modal" href="#<?php echo $disciplina1->id ?>"><?php echo $faltas->faltas ?></a></td>
                                            </tr>

                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div role="tabpanel" class="tab-pane animated fadeIn" id="tab-3">
                            </div>
                        </div>

                    </div>                   
                </div>

            </div> 

            <div class="modal fade" id="nota" role="dialog" aria-hidden="true" >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Lançar Nota</h4>
                        </div>

                        <form class="formularioNota" action="services/nota.php" method="POST">
                            <input type="hidden" name="function" value="nova"/> 
                            <input type="hidden" name="pessoa" value="<?php echo $_SESSION['UsuarioID'] ?>"/>
                            <div class="card">
                                <div class="card-body card-padding">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="fg-line form-group">
                                                <label>T1</label>
                                                <input type="text" class="form-control input-sm" id="valor1" name="t1" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="fg-line form-group">
                                                <label>T2</label>
                                                <input type="text" class="form-control input-sm" id="valor2" name="t2" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="fg-line form-group">
                                                <label>T3</label>
                                                <input type="text" class="form-control input-sm" id="valor3" name="t3" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="fg-line form-group">
                                                <label>T4</label>
                                                <input type="text" class="form-control input-sm" id="valor4" name="t4" required="">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">  
                                            <div class="fg-line form-group">
                                                <label>Disciplina</label><br>
                                                <select class="selectpicker" style="padding: 6px; border: none; width: 100%" id="md" name="md" onchange="buscaTiposPrevistos()">
                                                    <option selected="" disabled="" value="">SELECIONE</option>
                                                    <?php
                                                    if ($matriculasDisciplinas != "nenhum") {
                                                        foreach ($matriculasDisciplinas as $md) {
                                                            $disciplina = listarDisciplina($md->disc_id);
                                                            ?>
                                                            <option style="padding: 10px" value="<?php echo $md->id ?>"><?php echo $disciplina->nome ?></option>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo 'Nenhum Curso';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">  
                                            <div class="fg-line form-group">
                                                <label>Mês letivo</label><br>
                                                <select style="padding: 10px; border: none; width: 100%" id="tipos" name="tipoAvaliacao">
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

            <div class="modal fade" id="recp" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Lançar Recuperação</h4>
                        </div>

                        <form class="formularioRecp" action="services/nota.php" method="POST">
                            <input type="hidden" name="function" value="nova"/> 
                            <input type="hidden" name="pessoa" value="<?php echo $_SESSION['UsuarioID'] ?>"/>
                            <div class="card">
                                <div class="card-body card-padding">
                                    <div class="row">
                                        
                                        <div class="col-sm-6">  
                                            <div class="fg-line form-group">
                                                <label>Disciplina</label><br>
                                                <select class="selectpicker" style="padding: 6px; border: none; width: 100%" id="md_recp" name="md_recp" onchange="buscaMedias()">
                                                    <option selected="" disabled="" value="">SELECIONE</option>
                                                    <?php
                                                    if ($matriculasDisciplinas != "nenhum") {
                                                        foreach ($matriculasDisciplinas as $md) {
                                                            $disciplina = listarDisciplina($md->disc_id);
                                                            ?>
                                                            <option style="padding: 10px" value="<?php echo $md->id ?>"><?php echo $disciplina->nome ?></option>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo 'Nenhum Curso';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-sm-6">  
                                            <div class="fg-line form-group">
                                                <label>Média</label><br>
                                                <select style="padding: 10px; border: none; width: 100%" id="medias" name="medias">
                                                    <option selected="" disabled="" value="">SELECIONE</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="fg-line form-group">
                                                <label>Valor</label>
                                                <input type="text" class="form-control input-sm" id="valor_recp" name="valor_recp" required="">
                                            </div>
                                        </div>                                        
                                        
                                        <div class="col-sm-6">
                                            <div class="fg-line form-group">
                                                <label>Data da avaliação</label>
                                                <input id="data_recp" type="text" class="form-control input-sm data_recp" data-toggle="datepicker" name="data_recp" required="">
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

            <?php
            foreach ($matriculasDisciplinas as $md2) {
                $disciplina2 = listarDisciplina($md2->disc_id);
                $matriculaAluno1 = listarMatricula($md2->id_matricula);
                $faltas1 = frequenciaAlunoDisciplinaDetalhes($disciplina2->id, $matriculaAluno1->id_pessoa, "f");
                ?>  
                <div class="modal fade" id="<?php echo $disciplina2->id ?>" role="dialog" aria-hidden="true" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Detalhamento de faltas - <strong><?php echo $disciplina2->nome ?></strong></h4>
                            </div>
                            <table class="table table-inner table-vmiddle">

                                <tbody>

                                    <?php
                                    if ($faltas1 != "nenhum") {
                                        foreach ($faltas1 as $falta1) {
                                            ?>

                                            <tr>
                                                <td><?php echo formata_padrao_data($falta1->data) ?></td>
                                                <td class="f-500 c-red"></td>
                                            </tr>

                                            <?php
                                        }
                                    } else {
                                        echo "<p style='padding: 30px'>nenhuma falta</p>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>            

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
        $(function () {

            $('.dataAvaliacao').datepicker({
                autoHide: true,
                zIndex: 2048,
                language: 'pt-BR'
            });
            
            $('.data_recp').datepicker({
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
                complete: function (result) {
                    if (result.responseText === "success") {
                        swal({
                            title: "Atualizado com sucesso",
                            text: "Registro atualizado com sucesso",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.reload();
                        });
                    } else {
                        swal({
                            title: "Falha ao atualizar",
                            type: "error"
                        });
                    }
                }
            });
        });

        function buscaTiposPrevistos() {
            $.ajax({
                url: "services/tipoAvaliacao.php",
                type: 'POST',
                data: {function: 'listarTiposParaLancamento', md: $("#md").val()},
                success: function (data) {
                    $("#tipos").html(data);
                }
            });
        }

        function buscaMedias() {
            $.ajax({
                url: "services/media.php",
                type: 'POST',
                data: {function: 'buscaMediasPorMDCombo', md: $("#md_recp").val()},
                success: function (data) {
                    $("#medias").html(data);
                }
            });
        }                                                    

        $('#valor1').mask('00,00', {reverse: true});
        $('#valor2').mask('00,00', {reverse: true});
        $('#valor3').mask('00,00', {reverse: true});
        $('#valor4').mask('00,00', {reverse: true});
        $('#valor_recp').mask('00,00', {reverse: true});

    </script>      

</body>
</html>