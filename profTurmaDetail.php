<?php
require_once 'services/manager_session.php';
require_once 'services/turma.php';
require_once 'services/curso.php';
require_once 'services/nivel.php';
require_once 'services/sala.php';
require_once 'services/funcoes.php';
require_once 'services/matricula.php';
require_once 'services/pessoa.php';
require_once 'services/disciplinaProfessor.php';
require_once 'services/disciplina.php';

session_start();
ManagerSession::validaAcesso(28);
ManagerSession::setCookie();

if(!empty($_GET)){
    
    $disc_professor = listaDisciplinaProfessor($_GET['i']);
    $dados = listarTurma($disc_professor->id_turma);
    $curso = listarCurso($dados->id_curso);
    $sala = listarSala($dados->id_sala);
    $nivel = listarNivel($curso->id_nivel);
    $cursos = listarCursos();
    $salas = listarSalas();
    $disciplina = listarDisciplina($disc_professor->id_disciplina);
    $professor = listarPessoa($disc_professor->id_professor);
    
    $matriculas_alunos = matriculasRegularesPorTurma($dados->id);
    
    if($_SESSION['UsuarioTipo'] == 4){
        $link_back = "profTurmas";
        $nome_professor = "";
    }else{
        $link_back = "dps";
        $nome_professor = " (".$professor->nome.")";
    }
    
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
    <link href="vendors/bower_components/chosen/chosen.css" rel="stylesheet"> 
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
                        <div class="card">
                            <div class="card-header">
                                <h2><?php echo "$disciplina->nome $nome_professor"?></h2>
                            </div>
                            <div class="card-body card-padding">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="fg-line form-group">
                                            <label>Turma</label>
                                            <p><?php echo $dados->descricao ?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="fg-line form-group">
                                            <label>Turno</label>
                                            <p><?php echo getTurno($dados->turno) ?></p>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">  
                                        <div class="fg-line form-group">
                                            <label>Curso</label><br>
                                            <p><?php echo $curso->nome." - ".$nivel->nome ?></p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">  
                                        <div class="fg-line form-group">
                                            <label>Sala</label><br>
                                            <p><?php echo $sala->nome ?></p>
                                        </div>
                                    </div> 
                                   
                                    
                                </div>
                                 
                            </div>
                           
                        </div>
                            <div class="card-body card-padding">
                                    <a href="<?php echo $link_back ?>" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                                    <a href="frequenciaDisc?i=<?php echo $disc_professor->id ?>" style="float: right; margin: 5px" class="btn bgm-bluegray btn-icon-text"><i class="zmdi zmdi-assignment-check"></i> Lista de frequencia</a>
                                    <a href="planoDisc?i=<?php echo $disc_professor->id ?>" style="float: right; margin: 5px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-calendar-note"></i> Plano de aula</a>
                                    <a href="planejamentoDisc?i=<?php echo $disc_professor->id ?>" style="float: right; margin: 5px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-file"></i> Planejamento</a>
                            </div>
                        
                        <div class="card" style="margin-top: 90px">
                            <div class="action-header clearfix">
                                <div class="ah-label hidden-xs">Alunos</div>

                                <div class="ah-search">
                                    <input type="text" id="busca" placeholder="Buscar aluno..." class="ahs-input">

                                    <i class="ahs-close" data-ma-action="action-header-close">&times;</i>
                                </div>

                                <ul class="actions">
                                    <li>
                                        <a href="" data-ma-action="action-header-open">
                                            <i class="zmdi zmdi-search"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <i class="zmdi zmdi-info"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body card-padding">

                                <div class="contacts clearfix row" id="resultados">
                                    <?php
                                    if($matriculas_alunos != "nenhum"){
                                        foreach ($matriculas_alunos as $matricula){
                                            $aluno = listarPessoa($matricula->id_pessoa);
                                    ?>
                                    <div class="col-md-2 col-sm-4 col-xs-6">
                                        <div class="c-item">
                                            <a href="" class="ci-avatar">
                                                <img src="fotos/avatar.png" alt="">
                                            </a>

                                            <div class="c-info">
                                                <a href="perfilVisit"><strong><?php echo $aluno->nome ?></strong></a>
                                            </div>

                                            <div class="c-footer">
                                                <button onclick="lancaNota(<?php echo $matricula->id ?>)" class="waves-effect"><i class="zmdi zmdi-person-add"></i> Notas</button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    }else{
                                        echo "nenhum aluno";
                                    }
                                    ?>
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
    <script src="vendors/bower_components/chosen/chosen.jquery.js"></script>
    <script src="vendors/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
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
                    url: "services/matricula.php",
                    type: 'POST',
                    data: {function: 'matriculasRegularesPorTurmaInst', busca: $("#busca").val(), id_turma: <?php echo $dados->id ?>},
                    success: function (data) {
                        $("#resultados").html(data);
                    }
                });
            });            
            
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
        
        function excl(id_turma){
            $.ajax({
                    type: "POST",
                    data: {i:id_turma, function:'remover'},
                    url: "services/turma.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Removido com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.href='turmas';
                        });                         
                    }                    
                });
        }
        
        function lancaNota(id_matricula) {    
            location.href='notasDisciplina?m='+id_matricula+'&d=<?php echo $disciplina->id ?>';
        };        
        
        $('#valor').mask('#.##0,00', {reverse: true});
        
    </script>      

</body>
</html>
