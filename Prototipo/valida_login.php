	<?php
		session_start();
		
		include("crudMySql.php"); 
		
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		
		if(!empty($email) and !empty($senha)){
			if(read_database('usuario', "WHERE email = '$email'") != FALSE){
				$_SESSION['email'] = $email;
				$_SESSION['senha'] = $senha;	
				
				$result = read_database('usuario', "WHERE email = '$email'"); 
				
				if($result['senha'] <> $senha){	
					echo "<script>
		        	sweetAlert('Senha incorreta', 'Digite novamente a senha', 'error');
		        	setTimeout(function() { window.history.back(); }, 3000); </script>";
					
					session_unset();
					
				}else{
					$_SESSION['nome'] = $nome = $result['nome'];
					if($result['tipo'] == 'gerente'){
						echo "<script>
	        			sweetAlert('Login efetuado', 'Bem vindo, $nome', 'success');
	        			setTimeout(function() { location.href='gerente.php' }, 3000); </script>";
					}else if($result['tipo'] == 'morador'){
						echo "<script>
	        			sweetAlert('Login efetuado', 'Bem vindo, $nome', 'success');
	        			setTimeout(function() { location.href='inquilino.php' }, 3000); </script>";
					}else{
						echo "<script>
	        			sweetAlert('Login efetuado', 'Bem vindo, $nome', 'success');
	        			setTimeout(function() { location.href='principal.php' }, 3000); </script>";
					}
				}
			}else{
				echo "<script>
		        sweetAlert('Falha ao logar', 'Usuário não cadastrado', 'error');
		        setTimeout(function() { window.history.back(); }, 3000); </script>";
		        
		        session_unset();
				
			}
		}else{
			if(empty($email) and empty($senha)){
				echo "<script>
		        sweetAlert('Campos não informados', 'Os campos estão vazios, preencha-os', 'error');
		        setTimeout(function() { window.history.back(); }, 3000); </script>";
				
				session_unset();
				
			}else if(empty($email)){
				echo "<script>
		        sweetAlert('Email não informado', 'Preencha o campo email', 'error');
		        setTimeout(function() { window.history.back(); }, 3000); </script>";
		        
		        session_unset();
		        
			}else if(empty($senha)){
				echo "<script>
		        sweetAlert('Senha não informada', 'Preencha o campo senha', 'error');
		        setTimeout(function() { window.history.back(); }, 3000); </script>";
		        
		        session_unset();
		        
			}
		}
		
	?>