<?php
	#include das funcoes da tela inico
	include('functions/banco-veiculo-unico.php');

	#Instancia o objeto
	$banco = new bancoveiculounico();

	$Conteudo = $banco->CarregaHtml('veiculo-unico');
?>