<?php
	#include das funcoes da tela inico
	include('functions/banco-cadastro.php');

	#Instancia o objeto
	$banco = new bancocadastro();

	
	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('cadastro');
?>