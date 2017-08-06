
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
                    <a class="logo" href="inicial.php">

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
      <div id="divEditar">
      <form  class="formpagina" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

         <h4 for="txtEnderecoPartida">Ponto de Origem</h4>
         <input class="form-control2" type="text" id="txtEnderecoPartida" name="origem">

         <h4 for="pontoIntermediario">Ponto Intermediário</h4>
		     <input class="form-control2" type="text" id="pontoIntermediario" name="pontoIntermediario">
		     <button id="btAddWeypoints" class="btn btn-black">+ADD</button>

         <h4 for="txtEnderecoChegada">Ponto de Destino</h4>
         <input class="form-control2" type="text" id="txtEnderecoChegada" name="destino">

         <h4>Data da Viajem</h4>
         <input type="date" class="form-control2" placeholder="DatadaViajem" id="dataViajem" name="dataViajem" >

         <h4>Hora de Saída</h4>
         <input type="time" class="form-control2" placeholder="HoradeSaida" id="horaSaida" name="horaSaida" >

         <button id="btnEnviar" class="btn btn-black">Adicionar Destino</button>

         <h4>Ajuda de Custo</h4>
         <input type="text" class="form-control2" placeholder="R$" id="ajudaCusto" name="custo" >

		 <h4 class="distance">Distância</h4>
		 <input name="distancia"  id="distancia" class="disdur"><br />

		 <h4 class="duracion">Hora de Chegada</h4>
		 <input name="horaChegada"  id="duracao" class="disdur">

		 <input type="text" class="form-control2" id="waypoints" name="waypoints" ><br/>

         <input  name="cadastrar" id="OferConf" class="btn btn-black" value="Cadastrar" type="submit">

	</form>
</div>
<div id="mapa">
<?php

	//Importa os arquivos
	include ("conexao.php");
	include ("functionCalcLatLng.php");
	include("bloqueiaAcessoDiretoURL.php");

	//Abre a conexão com o banco
	$conexao = open_database();

	//Obtém email logado via sessão
	$email = $_SESSION['email'];

	//Verifica o clique do input submit 'cadastrar'
	if (!empty($_POST['cadastrar'])) {

		//Obtém dados dos inputs da página
		$origem = $_POST['origem'];
		$destino = $_POST['destino'];

		//Obtém as coordenadas: latitude e longitude da origem
		$geomOrigem = calcLatLong($origem);
		//Obtém as coordenadas: latitude e longitude do destino
		$geomDestino = calcLatLong($destino);

		//Obtém os valores dos campos da página
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

		//Verifica se há valor no input ajuda de custo, se não, atibue valor zero
		if($ajuda_custo == "" or $ajuda_custo === NULL)
			$ajuda_custo = (double) 0;

    	//Recebe string de script de inserção da carona para execução sql
		$sql = "INSERT INTO carona (email_usuario, geom_origem, geom_destino, descricao_origem,
				data_viajem, hora_saida, hora_chegada, ajuda_custo, descricao_destino, distancia)
	      		VALUES ('$email_usuario', $geom_origem, $geom_destino, '$descricao_origem',
	      		'$data_viajem', '$hora_saida', '$hora_chegada', '$ajuda_custo', '$descricao_destino',
	      		'$distancia')";

		//Controla atividades de cadastro da carona
		$caronaCadastrada = FALSE;
		$waypointCadastrado = TRUE;

		//Executa e verifica o status da inserção da carona
		if(mysqli_query($conexao, $sql)){

			//Seta true à variavel de controle de atividade
			$caronaCadastrada = TRUE;

			//Obtém string de waypoints
			$waypoints = $_POST['waypoints'];

			//Obtém vetor de String de waypoints
			$waypoints = explode('#', $waypoints);

			//Percorre vetor de waypoints para inserção
			for($i = 0; $i<sizeof($waypoints)-1; $i++){

				//Obtém a descrição do waypoint
				$descricao_waypoint = $waypoints[$i];

				//Obtém as coordenadas: latitude e longitude do waypoint
				$geom_waypoint = calcLatLong($descricao_waypoint);

				//Converte o waypoint numa Geometry tipo POINT
				$geom_waypoint = "ST_GeomFromText('Point($geom_waypoint)')";

				//Recebe string de script de inserção do waypoint para execução sql
				$sql1 = "INSERT INTO waypoints (email_usuario, data_carona, hora_carona, descricao, geom)
						VALUES ('$email_usuario', '$data_viajem', '$hora_saida', '$descricao_waypoint', $geom_waypoint);";

				//Executa e verifica o status da inserção do waypoint
				if(!(mysqli_query($conexao, $sql1))){

					//Seta false à variavel de controle de atividade
					$waypointCadastrado = FALSE;
				}
			}
		}

		//Verifica e emite alert de status de cadastro
		if($waypointCadastrado and $caronaCadastrada)

			//Emite mensagem de sucesso de cadastro de carona
			echo '<script>
				  		swal("Cadastrada!", "Sua Carona foi salva!", "success");
				  </script>';

		//Emite mensagem de insucesso de cadastro de carona
		else echo '<script>
				   		swal("Erro ao Cadastrar!", "Check novamente suas informações!", "error");
				   </script>';

		//Fecha a conexão com MySql
		mysqli_close($conexao);

	}

?>

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
    <script src ="assets/js/sweetalert/dist/sweetalert.min.js"></script>
  </body>
</html>
