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
		$usuario = strip_tags(trim(addslashes($_POST["usuario"])));
		$senha = strip_tags(trim(addslashes($_POST["senha"])));

		$flag = $banco->BuscaUsuario($usuario,$senha);

		if($flag){
			$banco->IniciaSessao($usuario);
			$banco->RedirecionaPara('admin');
		}
	}

	if($banco->VerificaSessao()){
		$deslogar = "<a href='".UrlPadrao."inicio/deslogar/' onClick=\"return confirm('Tem certeza que deseja deslogar ?')\" >Deslogar</a>";
	}

	if($this->PaginaAux[0] == 'acesso'){
		$msg = "Acesso Negado";
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('inicio');
	$Conteudo = str_replace('<%BOTAO%>', $botao, $Conteudo);
	$Conteudo = str_replace('<%SAIR%>', $deslogar, $Conteudo);
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
?>