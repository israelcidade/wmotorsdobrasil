<?php
	#include das funcoes da tela inico
	include('functions/banco-veiculo.php');

	#Instancia o objeto
	$banco = new bancoveiculo();

	#Declara Variaveis
	$botao = 'Salvar';
	$marca = '';
	$modelo = '';

	#Trabalha com o Editar
	if($this->PaginaAux[0] == 'editar'){
		$idveiculo = $this->PaginaAux[1];
		$botao = 'Atualizar';

		$result = $banco->BuscaVeiculo($idveiculo);
		$num_rows = $banco->Linha($result);

		if($num_rows){
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			$marca = $rs['marca'];
			$modelo = $rs['modelo'];
		}
	}

	#Trabalha com Post
	if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
		$marca = strip_tags(trim(addslashes($_POST["marca"])));
		$modelo = strip_tags(trim(addslashes($_POST["modelo"])));
		
		if($botao == 'Atualizar'){
			$SqlBanco = "Update c_veiculos SET marca = '".$marca."', modelo = '".$modelo."' where idveiculo = '".$idveiculo."' ";
		}else{
			$SqlBanco = "Insert Into c_veiculos (marca, modelo) VALUES ('".$marca."','".$modelo."')";
		}

		$banco->Execute($SqlBanco);
		$banco->RedirecionaPara('lista-veiculos');
	}

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('veiculo');
	$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
	$Conteudo = str_replace('<%MARCA%>',$marca,$Conteudo);
	$Conteudo = str_replace('<%MODELO%>',$modelo,$Conteudo);
?>