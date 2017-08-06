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
						<a class="logo" href="inicial.php"> <!-- logo image  --> <img src="assets/images/logo.png" alt="Logo"> QuickRide </a>
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


				</form>

				<div id="listagem" >
				          <table id="listagemCaronas">
				          <tr>
				          <th id="tabTitulo" colspan="4">OFERTAS DISPONÍVEIS</th>
				          </tr>
                          <tr>
                          <th id="tabTitulo">Email</th>
                          <th id="tabTitulo">Nome</th>
                          <th id="tabTitulo">Sexo</th>
                          <th id="tabTitulo">Telefone</th>
                          </tr>
                          </table>
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

	//Importa os arquivos
	include ("crudMySql.php");
	include ("functionCalcLatLng.php");
	include("bloqueiaAcessoDiretoURL.php");

	//Armazena o email do usuário logado
	$emailLogado = $_SESSION['email'];

	//Verifica e executa comandos internos caso o form seja enviado
	if ($_POST){

		//Obtém a data da viajem da página
		$dataViajem = $_POST['dataViajem'];

		//Obtém dados de inputs da página via metodo post
		$origem = $_POST['origem'];
		$destino = $_POST['destino'];

		//Obtém as coordenadas: latitude e longitude
		$origem = calcLatLong($origem);
		$destino = calcLatLong($destino);

		//Converte os dados numa Geometry tipo POINT
		$origem = "ST_GeomFromText('Point($origem)')";
		$destino = "ST_GeomFromText('Point($destino)')";

		//Tabelas usadas para a consulta sql
		$tabela = "Carona c, Waypoints w";

		//Campo de seleção para a consulta sql
		$campos = "c.email_usuario";

		//Condição de restrição para a consulta sql
		$condicao = "WHERE (((c.data_viajem = '$dataViajem' and ((ST_Distance(c.geom_origem, $origem) * (40075/360)) <= 20)) or
					(c.hora_saida = w.hora_carona and w.data_carona = '$dataViajem' and ((ST_Distance(w.geom, $origem) * (40075/360)) <= 20))) and
					((c.data_viajem = '$dataViajem' and ((ST_Distance(c.geom_destino, $destino) * (40075/360)) <= 20)) or
					(c.hora_saida = w.hora_carona and w.data_carona = '$dataViajem' and ((ST_Distance(w.geom, $destino) * (40075/360)) <= 20))))";

		//Recupera do banco segundo a consulta
		$result = read_database($tabela, $condicao, $campos);

		//Conta a quantidade de resultados obtidos na busca
		$contBuscasResult = sizeof($result);

		//Para contar e controlar o total de exibição de info de contato dos usuários
		$contBuscasResult1 = 0;

		//Percorre todas as linhas encontradas na consulta
		for ($i = 0; $i < sizeof($result); $i++) {

			//Obtém o email da consulta q satisfaz a condição da $condicao
			$emailBD = $result[$i]['email_usuario'];

			//Busca os dados do usuario(exceto o próprio) a partir de uma Consulta aninhada
			//recebendo como parâmetro chave o email obtido na consulta feita acima armazenada
			//na variável $result
			$result1 = read_database('usuario', "WHERE email = '$emailBD' and email <> '$emailLogado'");

			//Bloco Busca e armazena nas variáveis cada campo da row encontrada do $result1
			$emailContatoCarona = $result1[0]['email'];
			$nomeContatoCarona = $result1[0]['nome'];
			$sexoContatoCarona = $result1[0]['sexo'];
			$telefoneContatoCarona = $result1[0]['telefone'];

			//Verifica e seta na tabela se a consulta retornou algum resultado
			if($result and $result1){

				//Seta na tabela o(s) resultado(s) encontrado(s)
				echo "<script>
					  		listagemCaronas.innerHTML +=
				            	'<tr><td>$emailContatoCarona</td>".
								"<td>$nomeContatoCarona</td>".
								"<td>$sexoContatoCarona</td>".
								"<td>$telefoneContatoCarona</td>".
								"</tr>';
					  </script>";

			}else $contBuscasResult1++;
		}

		//Verifica se a consulta não retornou resultado e emite mensagem
		if($contBuscasResult - $contBuscasResult1 == 0){

			//Emite mensagem do resultado da consulta da busca
			echo "<script>
				  		listagemCaronas.innerHTML = 'Não existe resultado para essa busca!';
				  </script>";
		}

	}

?>
