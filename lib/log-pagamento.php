<?php
	#include das funcoes da tela inico
	include('functions/banco-log.php');

	#Instancia o objeto
	$banco = new bancolog();

	if($banco->VerificaSessaoAdmin()){

		$LOGS = $banco->ListaLogsPagamento($this->PaginaAux[0]);
		
		#Trabalha com deletar
		if($this->PaginaAux[0] == 'deletar'){
			$cpf = $banco->DeletaPagamento($this->PaginaAux[1]);
			if($cpf){
				$banco->RedirecionaPara('log-pagamento/'.$cpf);
			}
		}

		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('log-pagamento');
		$Conteudo = str_replace('<%LOGS%>',$LOGS,$Conteudo);
		$Conteudo = str_replace('<%CPF%>',$this->PaginaAux[0],$Conteudo);
		
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>