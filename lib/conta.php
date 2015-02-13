<?php
	#include das funcoes da tela inico
	include('functions/banco-conta.php');

	#Instancia o objeto
	$banco = new bancoconta();

	if($banco->VerificaSessao()){

		$info = $banco->BuscaInfoUsuario();
		
		if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
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
		
		//Endereco
		$Conteudo = str_replace('<%CEP%>',$info['cep'],$Conteudo);
		$Conteudo = str_replace('<%ENDERECO%>',$info['endereco'],$Conteudo);
		$Conteudo = str_replace('<%BAIRRO%>',$info['bairro'],$Conteudo);
		$Conteudo = str_replace('<%CIDADE%>',$info['cidade'],$Conteudo);
		$Conteudo = str_replace('<%ESTADO%>',$info['estado'],$Conteudo);
		
		
		//$Conteudo = str_replace('<%BUSCA%>',$Busca,$Conteudo);

	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
	
?>