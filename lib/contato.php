<?php
	#include das funcoes da tela inico
	include('functions/banco-contato.php');

	#Instancia o objeto
	$banco = new bancocontato();

	$Conteudo = $banco->CarregaHtml('contato');
?>