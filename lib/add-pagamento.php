<?php
	#include das funcoes da tela inico
	include('functions/banco-log.php');

	#Instancia o objeto
	$banco = new bancolog();

	if($banco->VerificaSessaoAdmin()){

		//$LOGS = $banco->ListaLogsPagamento($this->PaginaAux[0]);
		
		if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST['nome-form'] == 'pagamento'){
			$arr['cpf_pagamento'] = strip_tags(trim(addslashes($_POST["cpf-pagamento"])));
			$arr['plano_pagamento'] = strip_tags(trim(addslashes($_POST["plano-pagamento"])));
			$arr['data_pagamento'] = strip_tags(trim(addslashes($_POST["data-pagamento"])));
			$arr['validade_pagamento'] = strip_tags(trim(addslashes($_POST["validade-pagamento"])));
			
			if($banco->SalvaPagamento($arr)){
				$msg = $banco->MontaMsg('ok', 'Cadastro realizado com sucesso!');
			}
		}

		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('add-pagamento');
		//$Conteudo = str_replace('<%LOGS%>',$LOGS,$Conteudo);
		$Conteudo = str_replace('<%CPF%>',$this->PaginaAux[0],$Conteudo);
		
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>