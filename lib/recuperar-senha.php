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
			
		$result = $banco->InsereVeiculo($arr,$botao,$idveiculo);
		
		
	}

	$Conteudo = $banco->CarregaHtml('recuperar-senha');
	$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
?>