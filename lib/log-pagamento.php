<?php
	#include das funcoes da tela inico
	include('functions/banco-log.php');

	#Instancia o objeto
	$banco = new bancolog();

	if($banco->VerificaSessaoAdmin()){

		$LOGS = $banco->ListaLogsPagamento($this->PaginaAux[0]);

		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('log-pagamento');
		$Conteudo = str_replace('<%LOGS%>',$LOGS,$Conteudo);
		$Conteudo = str_replace('<%CPF%>',$this->PaginaAux[0],$Conteudo);
		
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>