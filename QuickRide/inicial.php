
<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tela Inicial</title>

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
        <a id="linkLogout" class="btn btn-black" href="encerrarSessoes.php">Logout</a><br/>
      <div class="text-center mt20">
          <h3><?php include("bloqueiaAcessoDiretoURL.php"); $nome = $_SESSION['nome']; echo "Olá, $nome"; ?>
          </h3>
        <h3>O que Deseja Fazer Hoje ?</h3>
        </br>
          <a id="btOfer" class="btn btn-black" href="oferecer.php">Oferecer Carona</a>    	
          <a id="btListar" class="btn btn-black" href="listarCarona.php">Listar Caronas</a>
          <a id="btPes" class="btn btn-black" href="pesquisar.php">Pesquisar Ofertas</a>
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
