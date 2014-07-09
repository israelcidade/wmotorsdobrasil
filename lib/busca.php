<?php
	#include das funcoes da tela inico
	include('functions/banco-busca.php');

	#Instancia o objeto
	$banco = new bancobusca();

	if($this->PaginaAux[0] == 'busca'){
		$categoria = $this->PaginaAux[1];
	}

	#Carrega o html de Auxilio
	$Auxilio = $banco->CarregaHtml('itens/lista-busca-itens');

	#Chama funcao Lista Manual passando o Auxilio
	$Busca = $banco->ListaResultado($Auxilio,$categoria);

	#Imprime Valores
	$Conteudo = $banco->CarregaHtml('busca');
	$Conteudo = str_replace('<%BUSCA%>',$Busca,$Conteudo);
?>