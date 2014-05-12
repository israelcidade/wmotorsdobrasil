<?php
	#include das funcoes da tela inico
	include('functions/banco-veiculo.php');

	#Instancia o objeto
	$banco = new bancoveiculo();

	#Declara Variaveis
	$botao = 'Salvar';

	#Trabalha com Post
	if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
		$marca = strip_tags(trim(addslashes($_POST["marca"])));
		$modelo = strip_tags(trim(addslashes($_POST["modelo"])));
	
		$SqlInsert = "Insert Into c_veiculos (marca, modelo) VALUES ('".$marca."','".$modelo."')";
		$banco->Execute($SqlInsert);
		$banco->RedirecionaPara('veiculo');
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('veiculo');
	$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
?>