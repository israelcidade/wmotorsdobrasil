<?php
	#include das funcoes da tela inico
	include('functions/banco-busca.php');

	#Instancia o objeto
	$banco = new bancobusca();

	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'busca-chassi'){
		$valor = strip_tags(trim(addslashes($_POST["chassi"])));
		$flag = 'chassi';
	}

	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'busca-completa'){
		$valor = strip_tags(trim(addslashes($_POST["chassi"])));
		
	}

	if($this->PaginaAux[0] == 'categoria'){
		$valor = $this->PaginaAux[1];
		$flag = 'categoria';
	}

	#Carrega o html de Auxilio
	$Auxilio = $banco->CarregaHtml('itens/lista-busca-itens');

	#Chama funcao Lista Manual passando o Auxilio
	$Busca = $banco->ListaResultado($Auxilio,$flag,$valor);

	#Imprime Valores
	$Conteudo = $banco->CarregaHtml('busca');
	$Conteudo = str_replace('<%BUSCA%>',$Busca,$Conteudo);
?>