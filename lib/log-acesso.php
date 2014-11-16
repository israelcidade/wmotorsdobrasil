<?php
	#include das funcoes da tela inico
	include('functions/banco-log.php');

	#Instancia o objeto
	$banco = new bancolog();

	if($banco->VerificaSessaoAdmin()){

		$LOGS = $banco->ListaLogs($this->PaginaAux[0]);

		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('log-acesso');
		$Conteudo = str_replace('<%LOGS%>',$LOGS,$Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>