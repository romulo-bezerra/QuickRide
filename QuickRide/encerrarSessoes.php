<?php
	
	//Inicia a sessão
	session_start();
	
	//Fecha todas as sessões abertas
	session_unset();
	
	//Destroi todas as sessões
	session_destroy();
	
	//Redireciona a página
	Header("location:login.php");  

?>