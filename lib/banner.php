<?php
	#include das funcoes da tela inico
	include('functions/banco-banner.php');

	#Instancia o objeto
	$banco = new bancobanner();

	$Conteudo = $banco->CarregaHtml('banner');
?>