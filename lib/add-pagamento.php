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
		$select_mensal= '';
		$select_anual = '';
		
		if($this->PaginaAux[0] == 'alterar'){
			$botao = 'Atualizar';
			$pagamento_id = $this->PaginaAux[1];
			$rs = $banco->BuscaPagamentoPorId($pagamento_id);
			$cpf = $rs['pagamento_cpf'];
			
			//PAGAMENTO TIPO
			$plano_pagamento = $rs['pagamento_tipo'];
			if($plano_pagamento == 'mensal'){
				$select_mensal = 'selected';
			}else{
				$select_anual = 'selected';
			}
			
			//DATA PAGAMENTO
			$data_pagamento_to = strtotime($rs['pagamento_data']);
			$data_pagamento = date('d/m/Y', $data_pagamento_to);
			
			//VALIDADE PAGAMENTO
			$validade_pagamento_to = strtotime($rs['pagamento_validade']);
			$validade_pagamento = date('d/m/Y', $validade_pagamento_to);
			
		}else{
			$cpf = $this->PaginaAux[0];
		}
		
		if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST['nome-form'] == 'pagamento'){
			$arr['cpf_pagamento'] = strip_tags(trim(addslashes($_POST["cpf-pagamento"])));
			$arr['plano_pagamento'] = strip_tags(trim(addslashes($_POST["plano-pagamento"])));
			$arr['data_pagamento'] = implode('-', array_reverse(explode('/', $_POST["data-pagamento"])));
			$arr['validade_pagamento'] = implode('-', array_reverse(explode('/', $_POST["validade-pagamento"])));
			
			if($botao == 'Salvar'){
				if($banco->SalvaPagamento($arr)){
					$banco->RedirecionaPara('log-pagamento/'.$this->PaginaAux[0]);
				}
			}else{
				$arr['pagamento_id'] = $pagamento_id;
				if($banco->AtualizaPagamento($arr)){	
					$banco->RedirecionaPara('log-pagamento/'.$cpf);
				}
			}
		}
		
		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('add-pagamento');
		$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
		$Conteudo = str_replace('<%CPF%>',$cpf,$Conteudo);
		$Conteudo = str_replace('<%SELECTEDMENSAL%>',$select_mensal,$Conteudo);
		$Conteudo = str_replace('<%SELECTEDANUAL%>',$select_anual,$Conteudo);
		$Conteudo = str_replace('<%PLANOPAGAMENTO%>',$plano_pagamento,$Conteudo);
		$Conteudo = str_replace('<%DATAPAGAMENTO%>',$data_pagamento,$Conteudo);
		$Conteudo = str_replace('<%VALIDADEPAGAMENTO%>',$validade_pagamento,$Conteudo);
		$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
		
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>