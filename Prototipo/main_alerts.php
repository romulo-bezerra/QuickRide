<?php 

	//Função imprime alert
	function status_cadastro(){
		session_start();
		
			if(!empty($_SESSION['cadSuccess']) and $_SESSION['cadSuccess'] === TRUE){
	        	echo '<script>alert("Cadastro realizado com sucesso!");</script>';
				session_unset();
	    	}else{
	    		echo '<script>alert("Falha ao cadastrar, tente novamente!");</script>';
				session_unset();
	    	}
		 	  
	}
	
	//Função imprime alert
	function status_login(){
		session_start();
		
			if(!empty($_SESSION['logSuccess']) and $_SESSION['logSuccess'] === TRUE){
	        	echo '<script>alert("Login realizado com sucesso!");</script>';
				session_unset();
	    	}else{
	    		echo '<script>alert("Falha ao realizar login, tente novamente!");</script>';
				session_unset();
	    	}
		 	  
	}
	
?>