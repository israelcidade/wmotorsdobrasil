<?php
	#include das funcoes da tela inico
	include('functions/banco-parceiros.php');

	#Instancia o objeto
	$banco = new bancoparceiros();

	#Declara Variaveis
	$msg  = '';

	$Conteudo = $banco->CarregaHtml('parceiros');
	$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
?>