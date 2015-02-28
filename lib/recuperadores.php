<?php
	#include das funcoes da tela inico
	include('functions/banco-parceiros.php');

	#Instancia o objeto
	$banco = new bancoparceiros();
	
	
	if($banco->VerificaSessao()){
	//$sobre = $banco->SelectSobre();
	
	
	$Conteudo = $banco->CarregaHtml('recuperadores');
	//$Conteudo = str_replace('<%SOBRE%>', $sobre, $Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>