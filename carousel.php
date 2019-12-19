<?php
require_once 'services/manager_session.php';
session_start();
ManagerSession::validaAcesso(22);
ManagerSession::setCookie();
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
    <!-- CSS -->
    <link href="css/app_1.min.css" rel="stylesheet">
    <link href="css/app_2.min.css" rel="stylesheet">
    
    <style>
.carousel-control { 
    width: 4%; 
}
.carousel-control.left,.carousel-control.right {
    margin-left:15px;
    background-image:none;
}
    
        
    </style>

</head>
<body>
    <?php include("topo.php") ?>

    <section id="main">
        <?php include ("menu.php") ?>

        <section id="content" style="margin-top: -15px">
           <div class="container">
                <div class="col-md-6 col-md-offset-3">
                <div class="carousel slide" data-ride="carousel" data-type="multi" data-interval="5000" id="myCarousel">
                  <div class="carousel-inner">
                    <div class="item active">
                      <div class="col-md-3  col-sm-6 col-xs-12"><a href="#"><img src="http://placehold.it/500/e499e4/fff&amp;text=1" class="img-responsive"></a></div>
                    </div>
                    <div class="item">
                      <div class="col-md-3 col-sm-6 col-xs-12"><a href="#"><img src="http://placehold.it/500/e477e4/fff&amp;text=2" class="img-responsive"></a></div>
                    </div>
                    <div class="item">
                      <div class="col-md-3 col-sm-6 col-xs-12"><a href="#"><img src="http://placehold.it/500/eeeeee&amp;text=3" class="img-responsive"></a></div>
                    </div>
                    <div class="item">
                      <div class="col-md-3 col-sm-6 col-xs-12"><a href="#"><img src="http://placehold.it/500/f4f4f4&amp;text=4" class="img-responsive"></a></div>
                    </div>
                    <div class="item">
                      <div class="col-md-3 col-sm-6 col-xs-12"><a href="#"><img src="http://placehold.it/500/f566f5/333&amp;text=5" class="img-responsive"></a></div>
                    </div>
                    <div class="item">
                      <div class="col-md-3 col-sm-6 col-xs-12"><a href="#"><img src="http://placehold.it/500/f477f4/fff&amp;text=6" class="img-responsive"></a></div>
                    </div>
                    <div class="item">
                      <div class="col-md-3 col-sm-6 col-xs-12"><a href="#"><img src="http://placehold.it/500/eeeeee&amp;text=7" class="img-responsive"></a></div>
                    </div>
                    <div class="item">
                      <div class="col-md-3 col-sm-6 col-xs-12"><a href="#"><img src="http://placehold.it/500/fcfcfc/333&amp;text=8" class="img-responsive"></a></div>
                    </div>
                  </div>
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
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

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        $('.carousel[data-type="multi"] .item').each(function(){
          var next = $(this).next();
          if (!next.length) {
            next = $(this).siblings(':first');
          }
          next.children(':first-child').clone().appendTo($(this));

          for (var i=0;i<2;i++) {
            next=next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
                }

            next.children(':first-child').clone().appendTo($(this));
          }
        });
    </script>      

</body>
</html>
