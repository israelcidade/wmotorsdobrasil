<?php
	#include das funcoes da tela inico
	include('functions/banco-recuperar-senha.php');

	#Instancia o objeto
	$banco = new bancorecuperarsenha();

	#Declara Variaveis
	$msg  = '';
	
	#Trabalha com Post
	if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
		$email = $_POST['email'];
			
		if($result = $banco->EnviarEmailRecuperarSenha($email)){
			
		}else{
			$msg = 'Esse email nao existe em nossos registros';
		}
		
		
	}

	$Conteudo = $banco->CarregaHtml('recuperar-senha');
	$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
?>