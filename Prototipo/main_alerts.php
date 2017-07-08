<?php 
	//Função imprime alert
	function status_cadastro(){
		if(!empty($_SESSION['cadSuccess']) and $_SESSION['cadSuccess'] == TRUE){
        	echo '<script>alert("Cadastro realizado com sucesso!");</script>';
    	}else if(isset($_SESSION['cadSuccess'])){
    		echo '<script>alert("Falha ao cadastrar, tente novamente!");</script>';
    	}
		session_unset(); 	  
	}
	//Função imprime alert determinado quanto a validação
	function status_validaLogin($session, $message){
		if(!empty($session) and $session == TRUE){
			echo '<script>alert("'.$message.'");</script>';
		}else if(isset($session)){
			echo '<script>alert("'.$message.'");</script>';
		}
	}
	
?>