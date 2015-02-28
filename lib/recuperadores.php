<?php
	#include das funcoes da tela inico
	include('functions/banco-parceiros.php');

	#Instancia o objeto
	$banco = new bancoparceiros();
	
	//$sobre = $banco->SelectSobre();
	
	
	$Conteudo = $banco->CarregaHtml('recuperadores');
	//$Conteudo = str_replace('<%SOBRE%>', $sobre, $Conteudo);
?>