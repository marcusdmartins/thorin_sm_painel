<?php
require_once 'classes/login.php';
require_once 'classes/funcoes.php';
require_once 'classes/usuario.php';

$login_controller = new Login_controller();
$login_controller->setCookie();
dois_acessos(1, 2);
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>La Provence</title>

    <!-- Vendor CSS -->
    <link href="vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <link href="vendors/bower_components/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
    <link href="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <link href="vendors/bower_components/mediaelement/build/mediaelementplayer.css" rel="stylesheet">
    <!-- CSS -->
    <link href="css/app_1.min.css" rel="stylesheet">
    <link href="css/app_2.min.css" rel="stylesheet">
</head>
<body>
    <?php include("topo.php") ?>

    <section id="main">
        <?php include ("menu.php") ?>

        <section id="content" style="margin-left: -10px; margin-right: -10px; margin-top: -15px">
            <div class="container">
                <form class="formularioCliente" action="classes/cliente.php" method="POST">
                    <input type="hidden" name="function" value="novoCliente"/>
                    <div class="card">
                        <div class="card-header">
                            <h2>Novo Cliente</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <input type="text" class="form-control input-sm" name="nome" placeholder="Nome do Cliente" required="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <input type="text" data-mask="000.000.000-00" class="form-control input-sm" name="cpf" placeholder="CPF">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="fg-line form-group">
                                        <input type="text" class="form-control input-sm" name="email" placeholder="Email">
                                    </div>
                                </div> 
                                
                                <div class="col-sm-4">
                                    <div class="fg-line form-group">
                                        <input type="text" class="form-control input-sm" name="contato" placeholder="Contato">
                                    </div>
                                </div>                                

                                <div class="col-sm-4">
                                    <div class="fg-line form-group">
                                        <input type="text" data-mask="00/00/0000" class="form-control input-mask" name="data_nasc" placeholder="Data de Nascimento">
                                    </div>
                                </div>                                

                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <input type="text" class="form-control input-sm" name="endereco" placeholder="Endereço" required="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <input type="text" class="form-control input-sm" name="cep" placeholder="CEP">
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
                        <button type="submit" style="float: right" class="btn bgm-purple btn-icon-text"><i class="zmdi zmdi-plus"></i> Salvar</button>
                    </div>
                </form>                

            </div>
        </section>
    </section>



    <!-- Page Loader 
    <div class="page-loader">
        <div class="preloader pls-blue">
            <svg class="pl-circular" viewBox="25 25 50 50">
            <circle class="plc-path" cx="50" cy="50" r="20" />
            </svg>
        </div>
    </div>
    -->
    <!-- Older IE warning message -->
    <!--[if lt IE 9]>
        <div class="ie-warning">
            <h1 class="c-white">Warning!!</h1>
            <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img src="img/browsers/chrome.png" alt="">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img src="img/browsers/firefox.png" alt="">
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opera.com">
                            <img src="img/browsers/opera.png" alt="">
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.apple.com/safari/">
                            <img src="img/browsers/safari.png" alt="">
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="img/browsers/ie.png" alt="">
                            <div>IE (New)</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>Sorry for the inconvenience!</p>
        </div>
    <![endif]-->

    <!-- Javascript Libraries -->
    <script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/bower_components/Waves/dist/waves.min.js"></script>
    <script src="vendors/bower_components/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="vendors/fileinput/fileinput.min.js"></script>
    <script src="vendors/bower_components/mediaelement/build/mediaelement-and-player.min.js"></script>
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
            $('.formularioCliente').ajaxForm({
                beforeSend: function () {
                    $('.loadingCliente').css({display: "block"});
                },
                success: function () {
                    $('.loadingCliente').css({display: "none"});
                },
                complete: function(result){
                    //status.html(xhr.responseText);
                    location.href='clienteDetail?i='+result.responseText;
                }
            });
        });
    </script>  
    
    <?php include("mensagens.php") ?>

</body>
</html>
