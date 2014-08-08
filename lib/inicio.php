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
			$banco->RedirecionaPara('lista-veiculos');
		}else{
			$banco->RedirecionaPara('inicio');
		}
	}

	if($this->PaginaAux[0] == 'acesso'){
		$msg = $banco->MontaMsg('erro',MSG_ERRO_ACESSO);
	}

	$UltimoVeiculo = $banco->BuscaUltimoVeiculo();

	$Marcas = $banco->BuscaMarcas();

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('inicio');
	$Conteudo = str_replace('<%BOTAO%>', $botao, $Conteudo);
	$Conteudo = str_replace('<%SAIR%>', $deslogar, $Conteudo);
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
	$Conteudo = str_replace('<%MARCA%>',$UltimoVeiculo['marca'],$Conteudo);
	$Conteudo = str_replace('<%MODELO%>',$UltimoVeiculo['modelo'],$Conteudo);
	$Conteudo = str_replace('<%ANOFAB%>',$UltimoVeiculo['anofab'],$Conteudo);
	$Conteudo = str_replace('<%ANOMOD%>',$UltimoVeiculo['anomod'],$Conteudo);
	$Conteudo = str_replace('<%PADRAO%>',$UltimoVeiculo['padrao'],$Conteudo);
	$Conteudo = str_replace('<%MARCAS%>',$Marcas,$Conteudo);
?>