<?php
	#include das funcoes da tela inico
	include('functions/banco-log.php');

	#Instancia o objeto
	$banco = new bancolog();

	if($banco->VerificaSessaoAdmin()){

		$botao = 'Salvar';
		$cpf = '';
		$plano_pagamento = '';
		$data_pagamento = '';
		$validade_pagamento = '';
		
		if($this->PaginaAux[0] == 'alterar'){
			$botao = 'Atualizar';
			$pagamento_id = $this->PaginaAux[1];
			$rs = $banco->BuscaPagamentoPorId($pagamento_id);
			$cpf = $rs['pagamento_cpf'];
			$plano_pagamento = $rs['pagamento_tipo'];
			$data_pagamento = $rs['pagamento_data'];
			$validade_pagamento = $rs['pagamento_validade'];
			
		}else{
			$cpf = $this->PaginaAux[0];
		}
		
		if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST['nome-form'] == 'pagamento'){
			$arr['cpf_pagamento'] = strip_tags(trim(addslashes($_POST["cpf-pagamento"])));
			$arr['plano_pagamento'] = strip_tags(trim(addslashes($_POST["plano-pagamento"])));
			$arr['data_pagamento'] = implode('-', array_reverse(explode('/', $_POST["data-pagamento"])));
			$arr['validade_pagamento'] = implode('-', array_reverse(explode('/', $_POST["validade-pagamento"])));
			
			if($banco->SalvaPagamento($arr)){
				$banco->RedirecionaPara('log-pagamento/'.$this->PaginaAux[0]);
			}
		}
		
		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('add-pagamento');
		$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
		$Conteudo = str_replace('<%CPF%>',$cpf,$Conteudo);
		$Conteudo = str_replace('<%PLANOPAGAMENTO%>',$plano_pagamento,$Conteudo);
		$Conteudo = str_replace('<%DATAPAGAMENTO%>',$data_pagamento,$Conteudo);
		$Conteudo = str_replace('<%VALIDADEPAGAMENTO%>',$validade_pagamento,$Conteudo);
		$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
		
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>