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

					<h4 for="txtEnderecoPartida" >OrigemBanco</h4>
					<input class="form-control2" type="text" id="origemBanco" name="origemBanco" value="">
					</br>

					<h4 for="txtEnderecoPartida" >DestinoBanco</h4>
					<input class="form-control2" type="text" id="destinoBanco" name="destinoBanco" value="">
					</br>

					<h4 for="txtEnderecoPartida" >WayPoints</h4>
					<input class="form-control2" type="text" id="waypointsBanco" name="waypointsBanco" value="">
					</br>

					<h4>Data da Viajem</h4>
					<input type="date" class="form-control2" placeholder="data" id="dataViajem" name="dataViajem" required>

					<input type="text" class="form-control2" id="distancia" name="distancia" >

					<br>
					<button type="button" class="btn btn-black" id="btPesquisar" name="btPesquisar">
						Confirmar
					</button>
					</br></br>

					<a class="btn btn-black" href="oferecer.php">Editar</a>
					<a class="btn btn-black" href="inicial.php">Excluir</a>
				</form>

				<div id="listagem" >
					<h4>-Ofertas Disponíveis-</h4>
					<h4 id="distanciaPes"></h4>
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
	
	if ($_POST) {
	
		$dataViajem = $_POST['dataViajem'];
	
		$result = read_database('carona', "WHERE data_viajem = '2017-07-19'");
	
		for ($i = 0; $i < sizeof($result); $i++) {
			$origem = $result[$i]['origem'];
			$destino = $result[$i]['destino'];
			$waypoints = $result[$i]['pontos_intermediarios'];
			echo "<script>
				  origemBanco.value = '$origem';
			 ndestinoBanco.value = '$destino';
					waypointsBanco.value = '$waypoints';
					</script>";
		}
	
		$enderecoPartida = $_POST['origem'];
		$enderecoChegada = $_POST['destino'];
	
	}
	
	$var = '<script>calculaQuilometragem("patos pb", "sousa pb");</script>';
	echo "$var";
	
	echo calcDistancia(-6.750598, -38.230485, -7.119350, -34.845590);
	
	function calcLatLong($localidade) {
		$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $localidade . '&key=AIzaSyAgf7lIrFnLz2J67wYUibx-jhl3XlNFbmQ');
	
		$output = json_decode($geocode);
	
		$lat = $output -> results[0] -> geometry -> location -> lat;
		$long = $output -> results[0] -> geometry -> location -> lng;
	
		$latLing = $lat . ',' . $long;
		return $latLing;
	};

/*
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
 */
  ?>
