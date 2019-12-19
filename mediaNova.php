<?php
require_once 'services/manager_session.php';
require_once 'services/tipoAvaliacao.php';
require_once 'services/pessoa.php';
require_once 'services/turma.php';
require_once 'services/matricula.php';
session_start();
ManagerSession::validaAcesso(31);
ManagerSession::setCookie();

$dados = listarTiposAvaliacao();

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
               <form class="formMedia" method="POST" action="services/media.php">
                   <input type="hidden" id="function" name="function" value="nova"/>
                   
                    <div class="card">
                        
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Nome da média</label>
                                        <input id="nome" name="nome" type="text" class="form-control input-sm" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="fg-line form-group">
                                        <label>Nota mínima</label>
                                        <input id="corte" name="corte" type="text" class="form-control input-sm" required="">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="fg-line form-group">
                                        <label>Tipo</label><br>
                                        <select class="chosen" placeholder="Selecione o tipo" name="tipo">
                                                <option disabled="" selected="" value="">SELECIONE</option>
                                                <option value="b">Bimestral</option>
                                                <option value="a">Anual</option>
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
                            </div>
                        </div>
                    </div>
                   
                    <div class="card">
                        <div class="list-group lg-odd-black">
                            <div class="action-header clearfix">
                                <div class="ah-label hidden-xs">Calendário de notas</div>
                            </div>

                            <?php
                            
                            if($dados != "nenhum"){
                                foreach ($dados as $dado){
                            ?>
                            
                            <div class="list-group-item media">
                                <div class="checkbox pull-left">
                                    <label>
                                        <input type="checkbox" class="matricula" id="<?php echo $dado->id ?>" name="tipos[]" value="<?php echo $dado->id ?>">
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                                <div class="pull-left">
                                    <img class="lgi-img" src="img/nivel.png" alt="">
                                </div>
                                
                                <div style="cursor: pointer" class="media-body" onclick="seleciona(<?php echo $dado->id ?>)" >
                                    <div class="lgi-heading"><?php echo $dado->descricao ?></div>
                                </div>
                            </div>
                            
                            <?php
                                }
                            }else{
                                echo "<p style='margin-left:30px'>nenhuma nota</p>";
                            }
                            ?>

                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link">Salvar</button>
                            <a href="medias" class="btn btn-link" data-dismiss="modal">Cancelar</a>
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
            
            $('.formMedia').ajaxForm({
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
                            location.href='medias';
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
        
        $('#corte').mask('00,00', {reverse: true});
       
    </script>      

</body>
</html>
