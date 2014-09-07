<?php
	#include das funcoes da tela inico
	include('functions/banco-inicio.php');

	#Declara variaveis
	$botao = 'Entrar';
	$deslogar = '';
	$msg = '';

	#Instancia o objeto
	$banco = new bancoinicio();

	if($this->PaginaAux[0] == 'deslogar'){
		$banco->FechaSessao();
		$banco->RedirecionaPara('inicio');
	}

	#Trabalha com Post
	if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
		$cpf = strip_tags(trim(addslashes($_POST["cpf"])));
		$senha = strip_tags(trim(addslashes($_POST["senha"])));

		$flag = $banco->BuscaUsuario($cpf,$senha);

		if($flag){
			$banco->IniciaSessao($cpf);
			$banco->RedirecionaPara('sobre');
		}else{
			$banco->RedirecionaPara('inicio/acesso');
		}
	}

	if($this->PaginaAux[0] == 'acesso'){
		$msg = $banco->MontaMsg('erro',MSG_ERRO_ACESSO);
	}

	if($this->PaginaAux[0] == 'acesso-negado'){
		$msg = $banco->MontaMsg('erro',MSG_ERRO_ACESSO_NEGADO);
	}

	$CarrosEmDestaque = $banco->CarrosEmDestaque();

	$Marcas = $banco->BuscaMarcas();

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('inicio');
	$Conteudo = str_replace('<%BOTAO%>', $botao, $Conteudo);
	$Conteudo = str_replace('<%SAIR%>', $deslogar, $Conteudo);
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
	$Conteudo = str_replace('<%CARROSEMDESTAQUE%>',$CarrosEmDestaque,$Conteudo);
	$Conteudo = str_replace('<%MARCAS%>',$Marcas,$Conteudo);
?>