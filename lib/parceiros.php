<?php
	#include das funcoes da tela inico
	include('functions/banco-parceiros.php');

	#Instancia o objeto
	$banco = new bancoparceiros();
	
	if($banco->VerificaSessao()){
		#Declara Variaveis
		$msg  = '';
	
		$Conteudo = $banco->CarregaHtml('parceiros');
		$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>