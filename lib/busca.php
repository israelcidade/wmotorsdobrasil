<?php
	#include das funcoes da tela inico
	include('functions/banco-busca.php');

	#Instancia o objeto
	$banco = new bancobusca();

	$Conteudo = $banco->CarregaHtml('busca');
?>