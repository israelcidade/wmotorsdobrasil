<?php
	#include das funcoes da tela inico
	include('functions/banco-conta.php');

	#Instancia o objeto
	$banco = new bancoconta();

	if($banco->VerificaSessao()){

		

		#Imprime Valores
		$Conteudo = $banco->CarregaHtml('conta');
		//$Conteudo = str_replace('<%BUSCA%>',$Busca,$Conteudo);

	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
	
?>