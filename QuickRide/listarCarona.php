<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ofertas</title>

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
        <div class="text-center mt20">
        <h3>Suas Ofertas</h3>

            <div id="divListaUsu" class="row">

                    <?php

                    	//Importa os arquivos
                    	include ("crudMySql.php");
						include("bloqueiaAcessoDiretoURL.php");

						//Recebe email logado da sessão
						$email = $_SESSION['email'];

						//Obtém o resultado da consulta
						$result = read_database('carona', "WHERE email_usuario = '$email'");

						//Percorre as tuplas da consulta
						for ($i = 0; $i < sizeof($result); $i++) {

							//Obtem os valores de cada coluna de cada tupla
							$origem = $result[$i]['descricao_origem'];
							$destino = $result[$i]['descricao_destino'];
							$dataViajem = $result[$i]['data_viajem'];
							$horaSaida = $result[$i]['hora_saida'];
							$ajudaCusto = $result[$i]['ajuda_custo'];

							//Seta na pagina a tag '<i>'
							echo '<i class="ion-ios-location"></i><br/>';

							//Verifica se a consulta retorna resultado
							if($result){

								//Seta na página do action a tag form comseus atributos
								echo '<form id="a" method="post" action="editarCarona.php">
								  	  	<input  id="listUsu" class="btn btn-white" name="inputEditar" type="submit" value="'.$origem.'|'.$destino.
								 		'|'.$dataViajem.'|'.$horaSaida.'|'.$ajudaCusto.'">
								 	  <form><br/>';
							}
						}

                    ?>

            </div><!-- row -->
        </div>
        </div>

    </header>

    <!-- script -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/smooth-scroll/dist/js/smooth-scroll.min.js"></script>
    <script src="assets/js/main.js"></script>

  </body>
</html>
