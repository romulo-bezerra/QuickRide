<?php

	//Função abre conexão com o banco
	function open_database() {
			
		try {
			
			//Recebe parâmetros para conexão com o banco
			$conn = mysqli_connect('localhost', 'root', '', 'projeto1_bdii');
			
			//Retorna a conexão
			return $conn;
			
		} catch (Exception $e) {
			
			//Emite mensagem de falha de conexao
			echo $e -> getMessage();
			
			//Retorno vazio de saída após falha na conexão
			return null;
		}
		
	}
	
	//Função fecha  aconexão com o banco
	function close_database($conn) {
			
		try {
				
			//Fecha a conexão com o banco	
			mysqli_close($conn);
			
		} catch (Exception $e) {
				
			//Retorna mensagem em caso de falha de fechamento da conexao	
			echo $e -> getMessage();
		}
		
	}
	
?>
