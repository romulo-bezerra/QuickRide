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
    <Link rel="stylesheet" href="assets/js/sweetalert/dist/sweetalert.css">
    
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
						QuickRide
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

         <h4 for="txtEnderecoPartida">Ponto de Origem</h4>
         <input class="form-control2" type="text" id="txtEnderecoPartida" name="origem">
         
         <h4 for="pontoIntermediario">Ponto Intermediário</h4>
		 <input class="form-control2" type="text" id="pontoIntermediario" name="pontoIntermediario">
		 <button id="btAddWeypoints" class="btn btn-black">+ADD</button>
		 
         <h4 for="txtEnderecoChegada">Ponto de Destino</h4>
         <input class="form-control2" type="text" id="txtEnderecoChegada" name="destino">

         <h4>Data da Viajem</h4>
         <input type="date" class="form-control2" placeholder="Nascimento" id="dataViajem" name="dataViajem" >

         <h4>Hora de Saída</h4>
         <input type="time" class="form-control2" placeholder="Nascimento" id="horaSaida" name="horaSaida" ><br/><br/>
		 
         <button id="btnEnviar" class="btn btn-black">Adicionar Destino</button>
         
         <h4>Ajuda de Custo</h4>
         <input type="text" class="form-control2" placeholder="R$" id="cell" name="custo" >

		 <h4 class="distance">Distância</h4>
		 <input name="distancia"  id="distancia" class="disdur"><br />

		 <h4 class="duracion">Hora de Chegada</h4>
		 <input name="horaChegada"  id="duracao" class="disdur">

		 <input type="text" class="form-control2" id="waypoints" name="waypoints" ><br/>

         <input class="btn btn-black" value="Confirmar" type="submit">

	</form>

<div id="mapa">
</div>

</div>
</header>

    <!-- script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgf7lIrFnLz2J67wYUibx-jhl3XlNFbmQ"></script>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/smooth-scroll/dist/js/smooth-scroll.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/mapa.js"></script>
    <Script src ="assets/js/sweetalert/dist/sweetalert.min.js"></script>
  </body>
</html>

<?php
	//FALTA FAZER O ROWBACK CASO O WAYPOINT NÃO SEJA CADASTRADO

	include("crudMySql.php");
	session_start();
	
	$email = $_SESSION['email'];
	
	if ($_POST) {
		$conexao = open_database();
		
		$origem = $_POST['origem'];
		$destino = $_POST['destino'];
		
		$geomOrigem = calcLatLong($origem);
		$geomDestino = calcLatLong($destino);
		
        $email_usuario = $email;
        $geom_origem = "ST_GeomFromText('Point($geomOrigem)')";
        $geom_destino = "ST_GeomFromText('Point($geomDestino)')";
        $descricao_origem = $_POST['origem'];
        $data_viajem = $_POST['dataViajem'];
        $hora_saida = $_POST['horaSaida'];
        $hora_chegada = $_POST['horaChegada'];
        $ajuda_custo = (double) $_POST['custo'];
        $descricao_destino = $_POST['destino'];
        $distancia = $_POST['distancia'];
    
		$sql = "INSERT INTO carona (email_usuario, geom_origem, geom_destino, descricao_origem, 
				data_viajem, hora_saida, hora_chegada, ajuda_custo, descricao_destino, distancia) 
	      		VALUES ('$email_usuario', $geom_origem, $geom_destino, '$descricao_origem', 
	      		'$data_viajem', '$hora_saida', '$hora_chegada', '$ajuda_custo', '$descricao_destino', 
	      		'$distancia')";
		
		$caronaCadastrada = FALSE;
		$waypointCadastrado = TRUE;
		
		if(mysqli_query($conexao, $sql)){
			$caronaCadastrada = TRUE;
		}
		
		//Obtém string de waypoints
		$waypoints = $_POST['waypoints'];
		//Obtém vetor de String de waypoints
		$waypoints = explode('#', $waypoints);
		
		for($i = 0; $i<sizeof($waypoints)-1; $i++){
				
			$descricao_waypoint = $waypoints[$i];
			$geom_waypoint = calcLatLong($descricao_waypoint);
			$geom_waypoint = "ST_GeomFromText('Point($geom_waypoint)')";
			
			$sql1 = "INSERT INTO waypoints (email_usuario, data_carona, hora_carona, descricao, geom)
					VALUES ('$email_usuario', '$data_viajem', '$hora_saida', '$descricao_waypoint', $geom_waypoint);";	
			
			if(!(mysqli_query($conexao, $sql1))){
				$waypointCadastrado = FALSE;
			}
				
		}

		if($waypointCadastrado and $caronaCadastrada)
			echo '<script>swal("Cadastrada!", "Sua Carona foi salva!", "success");</script>';
		else echo '<script>swal("Erro ao Cadastrar!", "Check novamente suas informações!", "error");</script>';

		mysqli_close($conexao);
	}
	
	
	function calcLatLong($localidade){
		//Retira espaços em branco da localidade
		$localidade = str_replace(" ","",$localidade);
		//Geocodifica  a localidade
		$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='
			       .$localidade.'&key=AIzaSyAgf7lIrFnLz2J67wYUibx-jhl3XlNFbmQ');
		//transforma em um json
		$output= json_decode($geocode);
		//Obtém a latitude
		$lat = $output->results[0]->geometry->location->lat;
  		//Obtém a longitude
  		$long = $output->results[0]->geometry->location->lng;
		//Formata a saida
  		$latLing = $lat .' '. $long;
		
	    return $latLing;
	};
		
?>
