<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Editar Carona</title>

    <link rel="stylesheet" href="assets/js/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src ="assets/js/sweetalert/dist/sweetalert.min.js"></script>

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

      <h3 class="nomepagina" >Editar Carona</h3>
      <div id="divEditar">
      <form  class="formpagina" method="post" action="">

         <h4 for="txtEnderecoPartida">Ponto de Origem</h4>
         <input class="form-control2" type="text" id="txtEnderecoPartida" name="origem">

         <h4 for="pontoIntermediario">Ponto Intermediário</h4>
		     <input class="form-control2" type="text" id="pontoIntermediario" name="pontoIntermediario">
		     <h5>Readicione novamente os Pontos de Passagem</h5>
		     <button id="btAddWeypoints" class="btn btn-black">+ADD</button>

         <h4 for="txtEnderecoChegada">Ponto de Destino</h4>
         <input class="form-control2" type="text" id="txtEnderecoChegada" name="destino">

         <h4>Data da Viajem</h4>
         <input type="text" class="form-control2" placeholder="DatadaViajem" id="dataViajem" name="dataViajem" readonly="true">

         <h4>Hora de Saída</h4>
         <input type="text" class="form-control2" placeholder="HoradeSaida" id="horaSaida" name="horaSaida"  readonly="true">

         <button id="btnEnviar" class="btn btn-black">Adicionar Destino</button>

         <h4>Ajuda de Custo</h4>
         <input type="text" class="form-control2" placeholder="R$" id="ajudaCusto" name="custo" >

		 <h4 class="distance">Distância</h4>
		 <input name="distancia"  id="distancia" class="disdur" readonly="true"><br />

		 <h4 class="duracion">Hora de Chegada</h4>
		 <input name="horaChegada"  id="duracao" class="disdur" readonly="true"><br />

		 <input type="text" class="form-control2" id="waypoints" name="waypoints" >

         <input class="btn btn-black" value="Confirmar" type="submit" name="Confirmar" id="Confirmar">
         <input class="btn btn-black" value="Excluir" type="submit" name="Excluir" id="Excluir">


	</form>
</div>

<div id="mapa">
<?php

	//Certifica o click do botão inputEditar da página listarCarona
	if(empty($_POST['inputEditar'])){

		//Emite mensagem de alerta caso nenhuma carona foi selecionada na página listarCarona
		echo "<script>
		          	sweetAlert('Carona não selecionada', 'Selecione uma carona antes para editar!', 'error');
					setTimeout(function() { location.href='listarCarona.php' }, 2000);
		      </script>";

	}else{

		//Recebe o valor do input submit 'inputEditar' da página listarCarona
		$inputEditar = $_POST['inputEditar'];

		//Quebra transformando em Array os valores
		$inputEditar = explode('|', $inputEditar);

		//Obtém os valores do Array em variáveis
		$origem = $inputEditar[0];
		$destino = $inputEditar[1];
		$dataViajem = $inputEditar[2];
		$horaSaida = $inputEditar[3];
		$ajudaCusto = (double) $inputEditar[4];

		//Seta nos inputs da página os valores
		echo '<script>
			  		document.getElementById("txtEnderecoPartida").value = "'.$origem.'";
					document.getElementById("txtEnderecoChegada").value = "'.$destino.'";
					document.getElementById("dataViajem").value = "'.$dataViajem.'";
					document.getElementById("horaSaida").value = "'.$horaSaida.'";
					document.getElementById("ajudaCusto").value = "'.$ajudaCusto.'";
			  </script>';
	}

	//Inporta o arquivo
	include ("conexao.php");

	//Importa o arquivo
	include ("functionCalcLatLng.php");

		//Abre a conexão com o banco
		$conexao = open_database();

		//Abre a sessão
		session_start();

		//Obtém o valor do email logado via sessão
		$email = $_SESSION['email'];

		//Certifica o clique do input submit 'Excluir'
		if(!empty($_POST['Excluir'])){

			//Obtém os dados dos inputs via metodo post
			$dataViajem = $_POST['dataViajem'];
			$horaSaida = $_POST['horaSaida'];

			//Recebe script sql de remoção de carona para execução do comando sql
			$sqlDelete = "DELETE FROM Carona WHERE email_usuario = '$email' and
					      data_viajem = '$dataViajem' and hora_saida = '$horaSaida'";

			//Verifica e executa o comando sql
			if(mysqli_query($conexao, $sqlDelete)){

				//Emite mensagem de sucesso de remoção de carona
				echo "<script>
					  		swal('Carona Deletada!', 'Sua Carona foi Deletada!', 'success');
							setTimeout(function() { location.href='listarCarona.php' }, 3000);
					  </script>";

			}
			//Emite mensagem de insucesso de remoção de carona
			else echo "<script>
							swal('Erro ao Deletar!', 'Não foi possível deletar sua carona!', 'error');
							setTimeout(function() { location.href='editarCarona.php' }, 3000);
					  </script>";

		}
		//Certifica o não clique do input submit 'Excluir'
		else{

			//Certifica o clique do input submit 'Confirmar'
			if (!empty($_POST['Confirmar'])) {

				//Obtém dos dados dos inputs via metodo post
				$origem = $_POST['origem'];
				$destino = $_POST['destino'];
				$dataViajem = $_POST['dataViajem'];
				$horaSaida = $_POST['horaSaida'];

				//Obtém as coordenadas: latitude e longitude da origem
				$geomOrigem = calcLatLong($origem);

				//Obtém as coordenadas: latitude e longitude do destino
				$geomDestino = calcLatLong($destino);

				//Obtém as informações de inserção para o banco
		        $geom_origem = "ST_GeomFromText('Point($geomOrigem)')";
		        $geom_destino = "ST_GeomFromText('Point($geomDestino)')";
		        $descricao_origem = $_POST['origem'];
		        $hora_chegada = $_POST['horaChegada'];
		        $ajuda_custo = (double) $_POST['custo'];
		        $descricao_destino = $_POST['destino'];
		        $distancia = $_POST['distancia'];

		        //Verifica se há valor no input 'Ajuda de Custo', se não atribui valor zero
				if($ajuda_custo == "" or $ajuda_custo === NULL)
					$ajuda_custo = (double) 0;


				//Recebe string sql de atualização de caronapara execução do comando
				$sqlUpdateCarona = "UPDATE Carona SET geom_origem = $geom_origem, geom_destino = $geom_destino,
								    descricao_origem = '$descricao_origem', hora_chegada = '$hora_chegada',
								    ajuda_custo = '$ajuda_custo', descricao_destino = '$descricao_destino',
								    distancia = '$distancia' WHERE email_usuario = '$email'
								    and data_viajem = '$dataViajem' and hora_saida = '$horaSaida'";

				//Controla fluxo de atividades e registra de status
				$caronaAtualizada = FALSE;
				$waypointDeletado = TRUE;
				$waypointCadastrado = TRUE;

				//Verifica e Exclue registro de carona
				if(mysqli_query($conexao, $sqlUpdateCarona)){

					//Atribue true à variável de controle de atividade
					$caronaAtualizada = TRUE;

					//Recebe String sql de exclusão de waypoints
					$sqlDeleteWay = "DELETE FROM Waypoints WHERE email_usuario = '$email' and
				                 data_carona = '$dataViajem' and hora_carona = '$horaSaida'";

					//Verifica e Exclue waypoints
					if(!mysqli_query($conexao, $sqlDeleteWay)){
						$waypointDeletado = FALSE;
					}
				}

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
					$sqlWay = "INSERT INTO waypoints (email_usuario, data_carona, hora_carona, descricao, geom)
							VALUES ('$email', '$dataViajem', '$horaSaida', '$descricao_waypoint', $geom_waypoint);";

					//Executa e verifica o status da inserção do waypoint
					if(!mysqli_query($conexao, $sqlWay)){

						//Atribue false à variável de controle de atividade
						$waypointCadastrado = FALSE;
					}
				}

				//Verifica as variáveis de controle de atividade para emissão de mensagem de alerta
				if($waypointCadastrado and $waypointDeletado and $caronaAtualizada)

					//Emite mensagem de alerta de sucesso de atualização de carona
					echo "<script>
						  		swal('Carona e Waypoint Atualizados!', 'Carona e ponto de passagem atualizados!', 'success');
								setTimeout(function() { location.href='listarCarona.php' }, 3000);
						  </script>";

					//Emite mensagem de alerta de insucesso de atualização de carona
					else echo "<script>
							   		swal('Erro ao atualizar a carona e waypoint!', 'Não foi possível atualizar carona e ponto de passagem!', 'error');
								setTimeout(function() { location.href='listarCarona.php' }, 3000);
						  </script>";

			}
		}

		//Fecha a conexão com o banco
		mysqli_close($conexao);

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
    <script src="assets/js/editar.js"></script>

  </body>

</html>
