<?php
	#include das funcoes da tela inico
	include('functions/banco-veiculo.php');

	#Instancia o objeto
	$banco = new bancoveiculo();

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('veiculo');
?>