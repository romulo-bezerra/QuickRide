<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Oferecer Carona</title>

    <!-- css -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
  </head>
  <body>

    <nav id="site-nav" class="navbar navbar-fixed-top navbar-custom">
        <div class="container">
            <div class="navbar-header">

                <!-- logo -->
                <div class="site-branding">
                    <a class="logo" href="index.html">

                        <!-- logo image  -->
                        <img src="assets/images/logo.png" alt="Logo">

                        Caronas 2017
                    </a>
                </div>

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-items" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div><!-- /.navbar-header -->

        </div><!-- /.container -->
    </nav>

    <header id="site-header" class="site-header valign-center">
      <div class="intro">

      <h3 class="nomepagina" >Oferecer Carona</h3>

      <form  class="formpagina" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

         <h4 for="txtEnderecoPartida">Origem</h4>
         <input class="form-control2" type="text" id="txtEnderecoPartida" name="origem">
         <h4 for="txtEnderecoChegada">Destino</h4>
         <input class="form-control2" type="text" id="txtEnderecoChegada" name="destino">
         <h4>Data da Viajem</h4>
         <input type="date" class="form-control2" placeholder="Nascimento" id="dataViajem" name="dataViajem" required>
         <h4>Hora de Saída</h4>
         <input type="time" class="form-control2" placeholder="Nascimento" id="horaSaida" name="horaSaida" required><br /><br />
         <button id="btnEnviar" class="btn btn-black">Adicionar Destino</button> <br /> <br />
         <h4>Ajuda de Custo</h4>
         <input type="text" class="form-control2" placeholder="R$" id="cell" name="custo" required>
		 <h4 class="distance">Distância</h4>
		 <input name="distancia"  id="distancia" class="disdur"><br />
		 <h4 class="duracion">Hora de Chegada</h4>
		 <input name="duracao"  id="duracao" class="disdur">
         <input class="btn btn-black" value="Confirmar" type="submit">
         
	</form>

<div id="mapa">
</div>

<!--<div id="trajeto-texto">
</div>-->


</div>
</header>

    <!-- script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgf7lIrFnLz2J67wYUibx-jhl3XlNFbmQ&callback=initMap"></script>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/smooth-scroll/dist/js/smooth-scroll.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/mapa.js"></script>

  </body>
</html>
