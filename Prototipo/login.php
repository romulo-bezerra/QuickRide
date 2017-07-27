<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

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



          <section id="registration" class="section registration">

              <div class="container">
                <div id="posiciona">

                  <div class="row"><br/>
                      <div class="col-md-12">
                          <h3>Sign in</h3>
                      </div>
                  </div>

                  <form method="post" action="valida_login.php">
                      <div class="row">
                          <div class="col-md-12" id="registration-msg" style="display:none;">
                              <div class="alert"></div>
                          </div>
                          <div class="campos">
	                          <input type="email" align="center" class="form-control" placeholder="Email" id="emailLog" name="email" required><br/>
	                          <input type="password" class="form-control" placeholder="Senha" id="senhaLog" name="senha" required>
                          </div>
                      </div>
                      <div class="text-center mt20">
                          <input type="submit" class="btn btn-black" id="btLogin" value="Login" href="inicial.php">
                      </div><br/>
                      <div class="text-center mt20">
                          <h4 id="CadLogin">Não é Cadastrado ?</h4>
                          <a id="LinkCad" class="btn btn-black" href="cadastro.php">Cadastrar</a>
                      </div>
                  </form>
                  </div>
              </div>

          </section>



        </div>

    </header>
    <?php
		include("main_alerts.php");
		session_start();
		status_validaLogin($_SESSION['valSuccess'], $_SESSION['message']);
	?>

    <!-- script -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/smooth-scroll/dist/js/smooth-scroll.min.js"></script>
    <script src="assets/js/main.js"></script>

  </body>
</html>
