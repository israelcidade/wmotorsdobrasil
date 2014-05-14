<?php
	#include das funcoes da tela inico
	include('functions/banco-sobre.php');

	#Instancia o objeto
	$banco = new bancosobre();

	$Conteudo = $banco->CarregaHtml('sobre');
?>