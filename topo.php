    <style>
        .titulo{
            font-family: 'Montserrat', sans-serif;
            font-size: 20px;
            font-weight: 800;
            font-style: italic;
        }
        
        .corpo{
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
        }

        body{
          font-family: 'Montserrat', sans-serif;  
        }        
    </style>

    <header id="header" class="clearfix" style="background-image: linear-gradient(to bottom right, #BE92FC, #2249FF)">
            <ul class="h-inner">
                <li class="hi-trigger ma-trigger" data-ma-action="sidebar-open" data-ma-target="#sidebar">
                    <div class="line-wrap">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>

                <li class="hi-logo hidden-xs">
                    <img src="img/raio.png" style="width: 85px; margin-top: -8px; margin-left: -20px"/>
                </li>

                <li class="pull-right" style="margin-right: -30px">
                    <ul class="hi-menu">
                        <li class="hidden-xs">
                            <h5 style="color: #fff; margin-left: -10px">Bem vindo</h5>
                        </li>

                        <li class="dropdown">
                            <a data-toggle="dropdown" href="">
                                <i class="him-icon zmdi zmdi-notifications"></i>
                                <i class="him-counts" id="counts"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg pull-right"> 
                                <div class="list-group him-notification">
                                    <div class="lg-header">
                                        Notificações

                                        <ul class="actions">
                                            <li class="dropdown">
                                                
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="lg-body" style="height: 200px; overflow: scroll" id="lista">
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                       
                        <li class="ma-trigger" data-ma-action="sidebar-open" data-ma-target="#chat">
                            <!-- <a href=""><i class="him-icon zmdi zmdi-comment-alt-text"></i></a> -->
                        </li> 
                    </ul>
                </li>
            </ul>

            <!-- Top Search Content -->
            <div class="h-search-wrap">
                <div class="hsw-inner">
                    <i class="hsw-close zmdi zmdi-arrow-left" data-ma-action="search-close"></i>
                    <form action="searchAll.php" method="GET">
                    <input type="text" name="busca" style="font-size: 12px" placeholder="Pesquise por vizinhos, arquivos...">
                    </form>
                </div>
            </div>
    </header>

<script type="text/javascript">

window.onload = function(){
    // Faz a primeira atualização
    atualizar();
};

// Função responsável por atualizar os alerts
function atualizar(){
    // Fazendo requisição AJAX
    var p1 = 'countAlertsMorador';
    var p2 = '<?php echo $_SESSION['UsuarioID']?>';
    som = document.getElementById("som");
    
    $.post('classes/alert.php',{f: p1, id:p2}, function (dados) {
      $('#counts').html(dados);
      }, 'JSON');
     var f2 = 'atualizaAlertsMorador';
    
    $.post('classes/alert.php',{f: f2, id:p2}, function (dados) {
      $('#lista').html(dados);
    }, 'HTML');
    
    $.post('classes/alert.php',{f: p1, id:p2}, function (dados) {
      var dadosNew = parseInt(dados);
      if (dadosNew > 0) {
          som.play();
          $("#globo").attr("class", "top-nav__notify");
      };
    }, 'JSON');

}

// Definindo intervalo que a função será chamada
setInterval("atualizar()", 3000);

</script>