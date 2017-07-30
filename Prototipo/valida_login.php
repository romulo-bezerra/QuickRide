	<?php
		session_start();
		
		include("crudMySql.php"); 
		include("main_alerts.php"); 
		
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		
		if(!empty($email) and !empty($senha)){
			if($result = read_database('usuario', "WHERE email = '$email'")){
				$_SESSION['email'] = $email;
				$_SESSION['senha'] = $senha;	
				$_SESSION['nome'] = $nome = $result[0]['nome'];
				
				if($result[0]['senha'] <> $senha){	
			    	$_SESSION['valSuccess'] = FALSE;
					$_SESSION['message'] = 'A senha está incorreta! Tente novamente';
					Header("location:login.php");
					
				}else{									
					$_SESSION['valSuccess'] = TRUE;
					$_SESSION['message'] = 'Login efetuado! Bem vindo, '.$nome;
					Header("location:inicial.php");
				}
			}else{						
				$_SESSION['valSuccess'] = FALSE;
				$_SESSION['message'] = 'Falha ao logar! Usuário não cadastrado';
				Header("location:login.php");
				
			}
		}
		
	?>