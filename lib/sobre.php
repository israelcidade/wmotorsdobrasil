<?php
	#include das funcoes da tela inico
	include('functions/banco-sobre.php');

	#Instancia o objeto
	$banco = new bancosobre();
	
	$sobre = $banco->SelectSobre();
	
	
	$Conteudo = $banco->CarregaHtml('sobre');
	$Conteudo = str_replace('<%SOBRE%>', $sobre, $Conteudo);
?>