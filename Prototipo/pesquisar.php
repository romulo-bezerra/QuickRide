<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Pedir Carona</title>

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
						<a class="logo" href="index.html"> <!-- logo image  --> <img src="assets/images/logo.png" alt="Logo"> QuickRide </a>
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
				<h3 class="nomepagina" >Pedir Carona</h3>

				<form  class="formpagina" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

					<h4 for="txtEnderecoPartida" >Origem</h4>
					<input class="form-control2" type="text" id="txtEnderecoPartida" name="origem">
					</br>

					<h4 for="txtEnderecoChegada" >Destino</h4>
					<input class="form-control2" type="text" id="txtEnderecoChegada" name="destino">
					</br>

					<h4>Data da Viajem</h4>
					<input type="date" class="form-control2" placeholder="data" id="dataViajem" name="dataViajem" required>
					<br></br>
					
					<input type="submit" class="btn btn-black" id="btPesquisar" name="btPesquisar" value="Buscar">
						
					</br></br>

					<a class="btn btn-black" href="oferecer.php">Editar</a>
					<a class="btn btn-black" href="inicial.php">Excluir</a>
				</form>

				<div id="listagem" >
					<h4>-Ofertas Disponíveis-</h4>
					<h4 id="listagemCaronas"></h4>
				</div>
			</div>

		</header>

		<!-- script -->
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgf7lIrFnLz2J67wYUibx-jhl3XlNFbmQ"></script>
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="bower_components/smooth-scroll/dist/js/smooth-scroll.min.js"></script>
		<script src="assets/js/main.js"></script>
		<script src="assets/js/pesquisar.js"></script>

	</body>
</html>

<?php
	include ("crudMySql.php");
	
	if ($_POST){
		
		//Obtém a data da viajem da página
		$dataViajem = $_POST['dataViajem'];
		
		//Obtém a origem da página
		$origem = $_POST['origem'];
		//Obtém o destino da página
		$destino = $_POST['destino'];
		
		//Obtém as coordenadas: latitude e longitude da origem  
		$origem = calcLatLong($origem);
		//Obtém as coordenadas: latitude e longitude do destino  
		$destino = calcLatLong($destino);
		
		//Converte a origem numa Geometry tipo POINT
		$origem = "ST_GeomFromText('Point($origem)')";
		//Converte o destino numa Geometry tipo POINT
		$destino = "ST_GeomFromText('Point($destino)')";
		
		//Tabelas usadas para a consulta sql
		$tabela = "Carona c, Waypoints w";
		//Campo de seleção para a consulta sql
		$campos = "c.email_usuario";
		//Condição de restrição para a consulta sql
		$condicao = "WHERE (((c.data_viajem = '$dataViajem' and 
					((ST_Distance(c.geom_origem, $origem) * (40075/360)) <= 20)) or 
					(c.hora_saida = w.hora_carona and w.data_carona = '$dataViajem' and 
					((ST_Distance(w.geom, $origem) * (40075/360)) <= 20))) and 
					((c.data_viajem = '$dataViajem' and ((ST_Distance(c.geom_destino, $destino) * (40075/360)) <= 20)) or 
					(c.hora_saida = w.hora_carona and w.data_carona = '$dataViajem' and 
					((ST_Distance(w.geom, $destino) * (40075/360)) <= 20))))";
					
		//Recupera do banco segundo a consulta
		$result = read_database($tabela, $condicao, $campos);
		
		//Percorre todas as linhas encontradas na consulta
		for ($i = 0; $i < sizeof($result); $i++) {
			$emailBD = $result[$i]['email_usuario'];
			
			//Busca os dados do usuario a partir de uma Consulta aninhada
			//recebendo como parâmetro chave o email obtido na consulta
			//feita acima armazenada na variável $result
			$result1 = read_database('usuario', "WHERE email = '$emailBD'");
			
			//Busca e armazena nas variáveis cada campo da row encontrada
			$emailContatoCarona = $result1[$i]['email'];
			$nomeContatoCarona = $result1[$i]['nome'];
			$sexoContatoCarona = $result1[$i]['sexo'];
			$telefoneContatoCarona = $result1[$i]['telefone'];
			$nascimentoContatoCarona = $result1[$i]['nascimento'];
			
			//Verifica se a consulta retornou algum resultado
			if($result and $result1){
				echo "<script> listagemCaronas.innerHTML += '| Email: $emailContatoCarona <br><br>".
					 "| Nome: $nomeContatoCarona <br><br>"."| Sexo: $sexoContatoCarona <br><br>".
					 "| Telefone: $telefoneContatoCarona <br><br>"."| Nascimento: $nascimentoContatoCarona <br>".
					 "----------------------------------------';</script>";	
			}else {
				echo "<script> listagemCaronas.innerHTML = '<br><br> Não há caronas para essa busca!'; </script> ";
			}
			
		}
	
	}
	
	//Função calcula coordenadas: latitude e longitude de uma localidade
	//Retorna um tipo String 'lat long'
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

<!--
 function calcDistancia($lat1, $long1, $lat2, $long2){
 $d2r = 0.017453292519943295769236;

 $dlong = ($long2 - $long1) * $d2r;
 $dlat = ($lat2 - $lat1) * $d2r;

 $temp_sin = sin($dlat/2.0);
 $temp_cos = cos($lat1 * $d2r);
 $temp_sin2 = sin($dlong/2.0);

 $a = ($temp_sin * $temp_sin) + ($temp_cos * $temp_cos) * ($temp_sin2 * $temp_sin2);
 $c = 2.0 * atan2(sqrt($a), sqrt(1.0 - $a));

 return 6368.1 * $c;
 };
-->