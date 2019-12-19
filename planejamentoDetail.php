<?php
require_once 'services/manager_session.php';
require_once 'services/curso.php';
require_once 'services/planejamento.php';
require_once 'services/funcoes.php';
session_start();
ManagerSession::validaAcesso(28);
ManagerSession::setCookie();

if(!empty($_GET)){
    $dados = listarPlanejamento($_GET['i']);
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
    <link href="vendors/summernote/dist/summernote.css" rel="stylesheet">
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
               <form>
                    <input type="hidden" name="function" value="novo"/>
                    <div class="card">
                        <div class="card-header">
                            <h2>Planejamento</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Titulo</label>
                                        <p><?php echo $dados->titulo ?></p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Data</label>
                                        <p><?php echo $dados->data ?></p>
                                    </div>
                                </div> 
                                <div class="col-sm-12">  
                                    <div class="fg-line form-group">
                                        <label>Texto</label><br>
                                        <div style="background-color: #F9F9F9; padding: 25px"><?php echo $dados->texto ?></div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Arquivo</label><br>
                                        <a target="_blank" href="<?php echo decodeArquivo($dados->arquivo) ?>">Arquivo</a>
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
                        <a href="planejamentoDisc?i=<?php echo $dados->dp_id ?>" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                        <a style="float: right; margin: 5px" class="btn bgm-red btn-icon-text delete" id="delete"><i class="zmdi zmdi-delete"></i> Excluir</a>
                        <a data-toggle="modal" href="#edit" style="float: right; margin: 5px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-edit"></i> Editar</a>
                        <a data-toggle="modal" href="#arquivo" style="float: right; margin: 5px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-file-plus"></i> Adicionar arquivo</a>
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
               <form>
                   <input type="hidden" id="function" name="function" value="edit"/>
                   <input type="hidden" id="id" name="id" value="<?php echo $dados->id ?>"/>
                   <input type="hidden" id="dp" name="dp" value="<?php echo $dados->dp_id ?>"/>
                   <input type="hidden" id="professor_id" name="professor_id" value="<?php echo $_SESSION['UsuarioID'] ?>"/>
                   <input type="hidden" id="texto" name="texto"/>

                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Título</label>
                                        <input id="titulo" type="text" value="<?php echo $dados->titulo ?>" class="form-control input-sm" name="titulo" required="">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Texto</label>
                                        <div class="editorTexto"></div>
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
                                    <a onclick="enviarPlan()" class="btn btn-link">Salvar</a>
                                    <a href="#" class="btn btn-link" data-dismiss="modal">Cancelar</a>
                                </div>                                    

                            </div>

                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="arquivo" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionar arquivos</h4>
                    </div>
                <form class="formArquivo" action="services/planejamento.php" method="POST" enctype="multipart/form-data">
                   <input type="hidden" id="function" name="function" value="upload"/>
                   <input type="hidden" id="id" name="id" value="<?php echo $dados->id ?>"/>

                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Título</label>
                                        <input id="titulo" type="file" class="form-control input-sm" name="arquivo" required="">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-link">Salvar</button>
                                    <a href="#" class="btn btn-link" data-dismiss="modal">Cancelar</a>
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
    <script src="vendors/summernote/dist/summernote-updated.min.js"></script>
    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]>
        <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
    <![endif]-->

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        $(".editorTexto").summernote({height:150});
        $(function(){
            $(".editorTexto").code('<?php echo $dados->texto ?>');
            
            $('.formArquivo').ajaxForm({
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
                            location.reload();
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
        
        function enviarPlan(){
            
            var id = $('#id').val();
            var professor_id = $('#professor_id').val();
            var dp = $('#dp').val();
            var titulo = $('#titulo').val();
            var texto = $('.editorTexto').code();
            //formData.append('arquivo', $('#arquivo').files[0]);
            
            $.ajax({
               url: "services/planejamento.php",
               type: 'POST',
               data: {function: 'edit', id: id, professor_id: professor_id, dp: dp,
                        titulo: titulo, texto: texto},
               success:function(data){
                   if(data === 'success'){
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
                            text: "Falha ao inserir registro: "+data,
                            type: "error"
                        });                        
                   }
                   
               }
            });            
        }        
        
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
        
        function excl(id){
            $.ajax({
                    type: "POST",
                    data: {i:id, function:'remover'},
                    url: "services/planejamento.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Removido com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.href='planejamentoDisc?i=<?php echo $dados->dp_id ?>';
                        });                         
                        
                        
                    }                    
                });
        }
        
        $('#valor').mask('#.##0,00', {reverse: true});
        
    </script>      

</body>
</html>
