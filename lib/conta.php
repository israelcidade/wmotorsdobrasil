<?php
	#include das funcoes da tela inico
	include('functions/banco-conta.php');

	#Instancia o objeto
	$banco = new bancoconta();

	if($banco->VerificaSessao()){

		$info = $banco->BuscaInfoUsuario();
		
		$info_pagamento = $banco->BuscaInfoPagamento($_SESSION['cpf']);
		
		
		if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST['nome-form'] == 'altera-senha'){
			$senhaAntiga = strip_tags(trim(addslashes($_POST["senhaAntiga"])));
			$senhaNova = strip_tags(trim(addslashes($_POST["senhaNova"])));
			$senhaNova2 = strip_tags(trim(addslashes($_POST["senhaNova2"])));
			
			$senhaBanco = $banco->BuscaSenhaAtual();
			
			if(md5($senhaAntiga) != $senhaBanco){
				$banco->RedirecionaPara('conta/erro_1');
			}elseif($senhaNova != $senhaNova2){
				$banco->RedirecionaPara('conta/erro_2');
			}else{
				$status = $banco->AtualizarSenha(md5($senhaNova));
				$banco->RedirecionaPara('conta/ok');
			}
			
		}
		
		if($this->PaginaAux[0] == 'erro_1'){
			$msg = $banco->MontaMsg('erro', MSG_ERRO_SENHA_IGUAL);
		}
		
		if($this->PaginaAux[0] == 'erro_2'){
			$msg = $banco->MontaMsg('erro', MSG_ERRO_SENHA_DIFERENTE_ATT);
		}
		
		if($this->PaginaAux[0] == 'ok'){
			$msg = $banco->MontaMsg('ok', MSG_SENHA_ATUALIZADA);
		}
		
		
		if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST['nome-form'] == 'altera-endereco'){
		
			$endereco['cep'] = strip_tags(trim(addslashes($_POST["cep"])));
			$endereco['endereco'] = strip_tags(trim(addslashes($_POST["endereco"])));
			$endereco['bairro'] = strip_tags(trim(addslashes($_POST["bairro"])));
			$endereco['cidade'] = strip_tags(trim(addslashes($_POST["cidade"])));
			$endereco['estado'] = strip_tags(trim(addslashes($_POST["estado"])));
			
				
			$banco->AtualizarEndereco($endereco);
			$banco->RedirecionaPara('conta');
				
		}
		
		#Imprime Valores
		$Conteudo = $banco->CarregaHtml('conta');
		$Conteudo = str_replace('<%NOME%>',$info['nome'],$Conteudo);
		$Conteudo = str_replace('<%DATANASC%>',date('d/m/Y', strtotime($info['nascimento'])),$Conteudo);
		$Conteudo = str_replace('<%EMAIL%>',$info['email'],$Conteudo);
		$Conteudo = str_replace('<%CPF%>',$info['cpf'],$Conteudo);
		$Conteudo = str_replace('<%RG%>',$info['rg'],$Conteudo);
		$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
		
		//Endereco
		$Conteudo = str_replace('<%CEP%>',$info['cep'],$Conteudo);
		$Conteudo = str_replace('<%ENDERECO%>',$info['endereco'],$Conteudo);
		$Conteudo = str_replace('<%BAIRRO%>',$info['bairro'],$Conteudo);
		$Conteudo = str_replace('<%CIDADE%>',$info['cidade'],$Conteudo);
		$Conteudo = str_replace('<%ESTADO%>',$info['estado'],$Conteudo);
		
		//Pagamento
		$Conteudo = str_replace('<%PLANO%>',$info_pagamento['pagamento_tipo'],$Conteudo);
		
		
		$timestamp_pagamento_validade = strtotime($info_pagamento['max']);
		$pagamento_validade = date('d/m/Y', $timestamp_pagamento_validade);
		$Conteudo = str_replace('<%VALIDADE%>',$pagamento_validade,$Conteudo);

	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
	
?>