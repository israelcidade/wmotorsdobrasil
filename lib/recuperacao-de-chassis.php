<?php
	#include das funcoes da tela inico
	include('functions/banco-chassis.php');

	#Instancia o objeto
	$banco = new bancochassis();

	#Declara Variaveis
	$msg  = '';

	$Conteudo = $banco->CarregaHtml('recuperacao-de-chassis');
	$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
?>