<?php
require_once 'services/manager_session.php';
require_once 'services/disciplinaProfessor.php';
session_start();
ManagerSession::validaAcesso(28);
ManagerSession::setCookie();

if(!empty($_GET)){
    
    $disc_professor = listaDisciplinaProfessor($_GET['i']);

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
                   <input type="hidden" id="function" name="function" value="novo"/>
                   <input type="hidden" id="dp" name="dp" value="<?php echo $disc_professor->id ?>"/>
                   <input type="hidden" id="professor_id" name="professor_id" value="<?php echo $_SESSION['UsuarioID'] ?>"/>
                   <input type="hidden" id="texto" name="texto"/>

                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Título</label>
                                        <input id="titulo" type="text" class="form-control input-sm" name="titulo" required="">
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
                                    <a href="planejamentoDisc?i=<?php echo $disc_professor->id ?>" class="btn btn-link" data-dismiss="modal">Cancelar</a>
                                </div>                                    

                            </div>

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

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        $(".editorTexto").summernote({height:350});
        $(function(){
//            $("#formPlan").submit(function() {
//                //$('#texto').val($('.editorTexto').code());
//                var formData = new FormData(this);
//
//                $.ajax({
//                    url: url: "services/planejamento.php",
//                    type: 'POST',
//                    data: formData,
//                    success: function(data) {
//                        alert(data);
//                    }
//                });
//            });               
        });
        
        function enviarPlan(){
            
            var professor_id = $('#professor_id').val();
            var dp = $('#dp').val();
            var titulo = $('#titulo').val();
            var texto = $('.editorTexto').code();
            //formData.append('arquivo', $('#arquivo').files[0]);
            
            $.ajax({
               url: "services/planejamento.php",
               type: 'POST',
               data: {function: 'novo', professor_id: professor_id, dp: dp,
                        titulo: titulo, texto: texto},
               success:function(data){
                   if(data !== 'error'){
                        swal({
                            title: "Salvo com sucesso",
                            text: "Registro atualizado com sucesso",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function(){
                            location.href='planejamentoDetail?i='+data;
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
       
    </script>      

</body>
</html>
