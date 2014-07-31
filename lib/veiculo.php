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
			foreach ($_POST as $key => $value) {
				$arr[$key] = $_POST[$key];
			}
		
			$result = $banco->InsereVeiculo($arr);

			if($result){
				$resultImagens = $banco->InsereImagens($_FILES['foto'],$arr);
			}
		}

		#Monta Imagem Principal
		$ImagemPrincipal = $banco->MontaImagemPrincipal($idveiculo);

		#Monta Imagens do Chassi
		$ImagemChassi = $banco->MontaImagemChassi($idveiculo);
		
		#Monta Imagens do Motor
		$ImagemMotor = $banco->MontaImagemMotor($idveiculo);

		#Monta Imagens do Cambio
		$ImagemCambio = $banco->MontaImagemcambio($idveiculo);

		#Monta o Select das Marcas
		$Marcas = $banco->MontaSelectMarcas($marca);

		#Monta o Select das Categorias
		$Categorias = $banco->MontaSelectCategorias($categoria);

		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('veiculo');

		//Monta Imagens
		$Conteudo = str_replace('<%IMAGEMPRINCIPAL%>',$ImagemPrincipal,$Conteudo);
		$Conteudo = str_replace('<%IMAGEMCHASSI%>',$ImagemChassi,$Conteudo);
		$Conteudo = str_replace('<%IMAGEMMOTOR%>',$ImagemMotor,$Conteudo);
		$Conteudo = str_replace('<%IMAGEMCAMBIO%>',$ImagemCambio,$Conteudo);

		//Resto
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