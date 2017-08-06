<?php
  	
  	//Importa arquivo
  	include("conexao.php");
  	
	//Função grava reqistros 
    function create_database($table, array $data){
        	
        //Abre a conexao com o banco	
        $conexao = open_database();
		
		//Adiciona virgula nas chaves
        $fields = implode(', ', array_keys($data));
		
		//Adiciona virgula nos valores
        $values = "'".implode("', '", $data)."'";
        
		//Recebe a sring sql de inserção para execução
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$values})";
        
		//Executa o comando sql da variável $sql
        if($conexao->query($sql)){
        	
			//Fecha a conexão após a execução do sql
        	mysqli_close($conexao);
			
			//Retorna true caso executado com sucesso o sql
			return TRUE;	
			
        }else{
        	
			//Fecha a conexão caso executado com insucesso o sql
        	mysqli_close($conexao);
			
			//Retorna false em caso de insucesso do sql
			return FALSE;
        }
		
    }
	
	//Ler Registros
    function read_database($table, $condition= null, $fields = '*'){   
        $conexao = open_database();
        
		//Formata condição caso exista ou não exista
        $condition = ($condition) ? " {$condition}" : null;    
		
		$dataGeral = array();
		$i = 0;
		
        $sql = "SELECT DISTINCT {$fields} FROM {$table}{$condition}";
        $result = $conexao->query($sql);
		
        if ($result->num_rows > 0) {
      	// output data of each row
      		while($row = $result->fetch_assoc()) {
          		$data = $row;
				$dataGeral[$i++] = $data;
      		}
  		} else {
      		return FALSE;
  		}
		mysqli_close($conexao);
		return $dataGeral;
    }
	
	//Altera Registros
    function update_database($table, array $data, $where = ""){
        $conexao = open_database();
        
		//Percorre as chaves e os valores
        foreach ($data as $key => $value){
            $fields[] = "{$key} = '{$value}'";
        }
        
		//Adiciona virgula nos valores
        $fields = implode(', ', $fields);
        
		//Formata a condição caso exista ou não exista
        $where = ($where)? " WHERE {$where}" : "";
        
        $sql = "UPDATE {$table} SET {$fields}{$where}";
        
        if($conexao->query($sql)){
        	mysqli_close($conexao);
			return TRUE;	
        }else{
        	mysqli_close($conexao);
			return FALSE;
        }
    }
    
	//Deleta Registros
	function delete_database($table, $condition = null){
		$conexao = open_database();
		
		//Formata a condição caso exista ou não exista
		$condition = ($condition)? " WHERE {$condition}" : "";
		
        $sql = "DELETE FROM {$table}{$condition}";
		
		if($conexao->query($sql)){
        	mysqli_close($conexao);
			return TRUE;	
        }else{
        	mysqli_close($conexao);
			return FALSE;
        }
	}
	
?>
