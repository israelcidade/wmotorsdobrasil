<?php
	#include das funcoes da tela inico
	include('functions/banco-veiculo.php');

	#Instancia o objeto
	$banco = new bancoveiculo();

	#Declara Variaveis
	$botao = 'Salvar';
	$botaodeletar = '';
	$categoria = '';
	$marca = '';
	$modelo = '';
	$anofab = '';
	$anomod = '';
	$padrao = '';
	$titulo = '';

	if($banco->VerificaSessao()){

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
				$categoria = $rs['categoria'];
				$modelo = $rs['modelo'];
				$anofab = $rs['anofab'];
				$anomod = $rs['anomod'];
				$padrao = $rs['padrao'];
				$titulo = $rs['titulo'];
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
			$categoria = strip_tags(trim(addslashes($_POST["categoria"])));
			$modelo = strip_tags(trim(addslashes($_POST["modelo"])));
			$anofab = strip_tags(trim(addslashes($_POST["anofab"])));
			$anomod = strip_tags(trim(addslashes($_POST["anomod"])));
			$padrao = strip_tags(trim(addslashes($_POST["padrao"])));
			$titulo = strip_tags(trim(addslashes($_POST["titulo"])));
			
			if($botao == 'Atualizar'){
				$SqlBanco = "Update c_veiculos SET categoria = '".$categoria."',marca = '".$marca."', modelo = '".$modelo."',anofab = '".$anofab."',anomod = '".$anomod."',padrao = '".$padrao."',titulo = '".$titulo."' where idveiculo = '".$idveiculo."' ";
			}else{
				$SqlBanco = "Insert Into c_veiculos (categoria,marca, modelo, anofab, anomod, padrao, titulo) VALUES ('".$categoria."','".$marca."','".$modelo."','".$anofab."','".$anomod."','".$padrao."','".$titulo."')";
			}

			$banco->Execute($SqlBanco);
			$banco->RedirecionaPara('lista-veiculos');
		}

		#Monta o Select das Marcas
		$Marcas = $banco->MontaSelectMarcas($marca);

		#Monta o Select das Categorias
		$Categorias = $banco->MontaSelectCategorias($categoria);

		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('veiculo');
		$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
		$Conteudo = str_replace('<%BOTAODELETAR%>',$botaodeletar,$Conteudo);
		$Conteudo = str_replace('<%CATEGORIAS%>',$Categorias,$Conteudo);
		$Conteudo = str_replace('<%MARCAS%>',$Marcas,$Conteudo);
		$Conteudo = str_replace('<%MODELO%>',$modelo,$Conteudo);
		$Conteudo = str_replace('<%ANOFAB%>',$anofab,$Conteudo);
		$Conteudo = str_replace('<%ANOMOD%>',$anomod,$Conteudo);
		$Conteudo = str_replace('<%PADRAO%>',$padrao,$Conteudo);
		$Conteudo = str_replace('<%TITULO%>',$titulo,$Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>