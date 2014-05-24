<?php
	#include das funcoes da tela inico
	include('functions/banco-veiculo.php');

	#Instancia o objeto
	$banco = new bancoveiculo();

	#Declara Variaveis
	$botao = 'Salvar';
	$botaodeletar = '';
	$marca = '';
	$modelo = '';

	#Trabalha com o Editar
	if($this->PaginaAux[0] == 'editar'){
		$idveiculo = $this->PaginaAux[1];
		$botao = 'Atualizar';
		$botaodeletar = "<a href='".UrlPadrao."veiculo/deletar/".$idveiculo."' onClick=\"return confirm('Tem certeza que deseja deletar ?')\" >Deletar</a>";	

		$result = $banco->BuscaVeiculo($idveiculo);
		$num_rows = $banco->Linha($result);

		if($num_rows){
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			$marca = $rs['marca'];
			$modelo = $rs['modelo'];
		}
	}

	#trabalha com Deeltar
	if($this->PaginaAux[0] == 'deletar'){
		$idveiculo = $this->PaginaAux[1];
		$banco->DeletaVeiculo($idveiculo);
		$banco->RedirecionaPara('lista-veiculos');
	}

	#Trabalha com Post
	if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
		$marca = strip_tags(trim(addslashes($_POST["marcas"])));
		$modelo = strip_tags(trim(addslashes($_POST["modelo"])));
		
		if($botao == 'Atualizar'){
			$SqlBanco = "Update c_veiculos SET marca = '".$marca."', modelo = '".$modelo."' where idveiculo = '".$idveiculo."' ";
		}else{
			$SqlBanco = "Insert Into c_veiculos (marca, modelo) VALUES ('".$marca."','".$modelo."')";
		}

		$banco->Execute($SqlBanco);
		$banco->RedirecionaPara('lista-veiculos');
	}

	#Monta o Select das Marcas
	$Marcas = $banco->MontaSelectMarcas($marca);

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('veiculo');
	$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
	$Conteudo = str_replace('<%BOTAODELETAR%>',$botaodeletar,$Conteudo);
	$Conteudo = str_replace('<%MARCAS%>',$Marcas,$Conteudo);
	$Conteudo = str_replace('<%MODELO%>',$modelo,$Conteudo);

?>