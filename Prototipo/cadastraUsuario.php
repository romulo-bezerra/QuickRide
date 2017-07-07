<?php
	include("crudMySql.php");
	
	$nome = $_POST['nome'].' '.$_POST['sobrenome'];
	
	$usuario = array(
        'email' => $_POST['email'],
        'nome' => $nome,
        'senha' => $_POST['senha'],
        'sexo' => $_POST['sexo'],
        'telefone' => $_POST['telefone'],
        'nascimento' => $_POST['nascimento']
    );
	
	if(create_database('usuario', $usuario)){
		session_start();
		//Guarda informação de sucesso do cadastro
    	$_SESSION['cadSuccess'] = TRUE;
		//Linka para a tela inicial.php
		Header("location:inicial.php");
		
	}else{
		session_start();
		//Guarda informação de sucesso do cadastro
    	$_SESSION['cadSuccess'] = FALSE;
		//Linka para a tela cadastro.php
		Header("location:cadastro.php");
	}
	
?>