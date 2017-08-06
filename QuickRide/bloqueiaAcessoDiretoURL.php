<!DOCTYPE html>
<html>
  <head>
  	<link rel="stylesheet" href="assets/js/sweetalert/dist/sweetalert.css">
  	<script src ="assets/js/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body>
	<?php
	
		//Inicia a sessão
		session_start();	
		
		//Verifica se usuário está logado 
		if(empty($_SESSION['email']) and empty($_SESSION['senha'])){
			
			//Emite status de logado e redireciona a página
			echo "<script>
		          	sweetAlert('Você não logou', 'Por favor entre no sistema', 'error');
		        	setTimeout(function() { location.href='index.html' }, 3000); 
		          </script>";
			
			//Fecha todas as sessões criadas
			session_unset();
			
			//Exita a execução 
			exit;
		}
	?>
  </body>
</html>