<?php
	#include das funcoes da tela inico
	include('functions/banco-faq.php');

	#Instancia o objeto
	$banco = new bancofaq();
	
	if($banco->VerificaSessao()){
		#Declara Variaveis
		$msg  = '';
	
		$Conteudo = $banco->CarregaHtml('faq');
		$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>