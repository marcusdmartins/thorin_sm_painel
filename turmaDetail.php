<?php
require_once 'services/manager_session.php';
require_once 'services/turma.php';
require_once 'services/curso.php';
require_once 'services/nivel.php';
require_once 'services/sala.php';
require_once 'services/funcoes.php';

session_start();
ManagerSession::validaAcesso(21);
ManagerSession::setCookie();

if(!empty($_GET)){
    $dados = listarTurma($_GET['i']);
    $curso = listarCurso($dados->id_curso);
    $sala = listarSala($dados->id_sala);
    $nivel = listarNivel($curso->id_nivel);
    $cursos = listarCursos();
    $salas = listarSalas();
    
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
                            <h2>Turma</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Nome</label>
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
                        <div class="preloader loadingCliente" style="display: none; float: left; padding-top: 5px">
                            <svg class="pl-circular" viewBox="25 25 50 50">
                            <circle class="plc-path" cx="50" cy="50" r="20"/>
                            </svg>
                        </div>                    
                    <div class="card-body">
                        <a href="turmas" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                        <a style="float: right; margin: 5px" class="btn bgm-red btn-icon-text delete" id="delete"><i class="zmdi zmdi-delete"></i> Excluir</a>
                        <a data-toggle="modal" href="#edit" style="float: right; margin: 5px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-edit"></i> Editar</a>
                    </div>
            </div>              
        </section>
        
        <div class="modal fade" id="edit" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">EDITAR DADOS</h4>
                    </div>

                    <form class="formularioTurma" action="services/turma.php" method="POST">
                        <input type="hidden" name="function" value="edit"/> 
                        <input type="hidden" name="id" value="<?php echo $dados->id ?>"/>
                        <div class="card">
                            <div class="card-body card-padding">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="fg-line form-group">
                                            <label>Nome</label>
                                            <input type="text" value="<?php echo $dados->descricao ?>" class="form-control input-sm" name="nome" required="">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">  
                                        <div class="fg-line form-group">
                                            <label>Turno</label><br>
                                            <select class="chosen" placeholder="Selecione o turno" name="turno">

                                                    <?php
                                                    $turnos = getTurnos();
                                                    if($turnos != "nenhum"){
                                                    foreach ($turnos as $turno) {
                                                        ?>
                                                        <option <?php if($turno["ab"] == $dados->turno){?> selected="" <?php }?> value="<?php echo $turno["ab"] ?>"><?php echo $turno["nome"] ?></option>
                                                        <?php
                                                    }
                                                    }else{
                                                        echo 'nenhum turno';
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>                                    

                                    <div class="col-sm-6">  
                                        <div class="fg-line form-group">
                                            <label>Curso</label><br>
                                            <select class="chosen" placeholder="Selecione o curso" name="curso">

                                                    <?php
                                                    if($cursos != "nenhum"){
                                                    foreach ($cursos as $curso) {
                                                        $nivel_select = listarNivel($curso->id_nivel);
                                                        ?>
                                                        <option <?php if($dados->id_curso == $curso->id){?> selected="" <?php }?> value="<?php echo $curso->id ?>"><?php echo $curso->nome." - ".$nivel_select->nome ?></option>
                                                        <?php
                                                    }
                                                    }else{
                                                        echo 'nenhum curso';
                                                    }
                                                    ?>
                                                </optgroup>

                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">  
                                        <div class="fg-line form-group">
                                            <label>Sala</label><br>
                                            <select class="chosen" placeholder="Selecione o curso" name="sala">
                                                    <?php
                                                    if($salas != "nenhum"){
                                                    foreach ($salas as $sala) {
                                                        ?>
                                                        <option <?php if($dados->id_sala == $sala->id){?> selected="" <?php }?> value="<?php echo $sala->id ?>"><?php echo $sala->nome ?></option>
                                                        <?php
                                                    }
                                                    }else{
                                                        echo 'nenhum curso';
                                                    }
                                                    ?>
                                                </optgroup>

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
        
        $('#valor').mask('#.##0,00', {reverse: true});
        
    </script>      

</body>
</html>
