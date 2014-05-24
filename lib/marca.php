<?php
	#include das funcoes da tela inico
	include('functions/banco-marca.php');

	#Instancia o objeto
	$banco = new bancomarca();

	#Declara Variaveis
	$botao = 'Salvar';
	$botaodeletar = '';
	$marca = '';

	if($banco->VerificaSessao()){

		#Trabalha com Editar
		if($this->PaginaAux[0] == 'editar'){
			$idmarca = $this->PaginaAux[1];
			$botao = 'Atualizar';
			$botaodeletar = "<a href='".UrlPadrao."marca/deletar/".$idmarca."' onClick=\"return confirm('Tem certeza que deseja deletar ?')\" >Deletar</a>";	

			$result = $banco->BuscaMarca($idmarca);
			$num_rows = $banco->Linha($result);

			if($num_rows){
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				$marca = $rs['marca'];
			}
		}

		#trabalha com Deeltar
		if($this->PaginaAux[0] == 'deletar'){
			$idmarca = $this->PaginaAux[1];
			$banco->DeletaMarca($idmarca);
			$banco->RedirecionaPara('lista-marcas');
		}

		#Trabalha com Post
		if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
			$marca = strip_tags(trim(addslashes($_POST["marca"])));
			
			if($botao == 'Atualizar'){
				$SqlBanco = "Update c_veiculos SET marca = '".$marca."', modelo = '".$modelo."' where idveiculo = '".$idveiculo."' ";
			}else{
				$SqlBanco = "Insert Into c_marcas (marca) VALUES ('".$marca."')";
			}

			$banco->Execute($SqlBanco);
			$banco->RedirecionaPara('lista-marcas');
		}

		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('marca');
		$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
		$Conteudo = str_replace('<%BOTAODELETAR%>',$botaodeletar,$Conteudo);
		$Conteudo = str_replace('<%MARCA%>',$marca,$Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>