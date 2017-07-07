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
	
?>