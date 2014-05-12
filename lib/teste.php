<?php
	#include das funcoes da tela inico
	include('functions/banco-teste.php');

	#Instancia o objeto
	$banco = new bancoteste();

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('teste');
?>