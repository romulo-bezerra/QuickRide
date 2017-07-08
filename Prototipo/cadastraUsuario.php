<?php
	include("crudMySql.php");
	
	//Concatena nome e sobrenome
	$nome = $_POST['nome'].' '.$_POST['sobrenome'];
	
	//Monta array com os dados
	$usuario = array(
        'email' => $_POST['email'],
        'nome' => $nome,
        'senha' => $_POST['senha'],
        'sexo' => $_POST['sexo'],
        'telefone' => $_POST['telefone'],
        'nascimento' => $_POST['nascimento']
    );
	//Inicia a sessão
	session_start();
	
	if(create_database('usuario', $usuario)){
		//Guarda informação de sucesso do cadastro
    	$_SESSION['cadSuccess'] = (bool) TRUE;
		//Linka para a tela inicial.php
		Header("location:login.php");
		
	}else{
		//Guarda informação de sucesso do cadastro
    	$_SESSION['cadSuccess'] = (bool) FALSE;
		//Linka para a tela cadastro.php
		Header("location:cadastro.php");
	}
	
?>