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

      <form  class="formpagina" method="post" action="oferecer.php">

         <h4 for="txtEnderecoPartida">Origem</h4>
         <input class="form-control2" type="text" id="txtEnderecoPartida" name="origem">
         </br>
         <h4 for="txtEnderecoChegada">Destino</h4>
         <input class="form-control2" type="text" id="txtEnderecoChegada" name="destino">
         </br></br>
         <button id="btnEnviar" class="btn btn-black">Adicionar Destino</button>
         </br><br>
         <h4>Data da Viajem</h4>
         <input type="date" class="form-control2" placeholder="Nascimento" id="cell" name="dataViajem" required>
         <h4>Hora de Saída</h4>
         <input type="time" class="form-control2" placeholder="Nascimento" id="hora" name="horaSaida" required>
         <h4>Ajuda de Custo</h4>
         <input type="text" class="form-control2" placeholder="R$" id="cell" name="custo" required>
      	 </br></br>
      	 
      	 <!-- Seta titulo da distância -->
		 <h4 class="distance">Distância</h4>
		 <!-- Div armazena resultado da distância -->
		 <input name="distancia" disabled="disabled" id="distancia" class="disdur"><br />
		
		 <!-- Seta titulo da duração -->
		 <h4 class="duracion">Duração</h4>
		 <!-- Div armazena resultado da duração da viajem -->
		 <input name="duracao" disabled="disabled" id="duracao" class="disdur">
		
         <input class="btn btn-black" value="Confirmar" type="submit">
	</form>
	
	<?php
		include("crudMySql.php");
		
		if(!empty($_POST['distancia']) and !empty($_POST['duracao'])){
		
			//Monta array com os dados
			$usuario = array(
		        'usuario' => $_SESSION['email'],
		        'oferecimento' => TRUE,
		        'origem' => $_POST['origem'],
		        'data_viajem' => $_POST['dataViajem'],
		        'hora_saida' => $_POST['horaSaida'],
		        'hora_chegada' => $_POST['sexo'],//Falta configurar
		        'ajuda_custo' => $_POST['custo'],
		        'destino' => $_POST['destino'],
		        'distancia' => $_POST['distancia']
		    );
			
			
			
		}else{
			echo '<script>alert("Você não traçou a rota. CLIQUE em Adicionar Destino");</script>';
		}
		
			
		
		
		
		
		
	
	?>

<div id="mapa">
</div>

<!--<div id="trajeto-texto">
</div>-->


</div>
</header>

    <!-- script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjgDETAGa13nEXRxZypOnLqc8PhzLSdoc&callback=initMap"></script>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/smooth-scroll/dist/js/smooth-scroll.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/mapa.js"></script>

  </body>
</html>
