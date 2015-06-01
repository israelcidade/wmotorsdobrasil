<?php
	#include das funcoes da tela inico
	include('functions/banco-parceiros.php');

	#Instancia o objeto
	$banco = new bancoparceiros();
	
	$botao = 'Salvar';
	$nome = '';
	$telefone = '';
	
	if($this->PaginaAux[0] == 'editar'){
		$id = $this->PaginaAux[1];
		$botao = 'Atualizar';
		$result = $banco->BuscaParceiro($id);
		$num_rows = $banco->Linha($result);
		if($num_rows){
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			$nome = $rs['parceiro_nome'];
			$telefone = $rs['parceiro_telefone'];
			$caminho_foto = $rs['parceiro_foto_caminho'];
			$img = '<img src="'.UrlPadrao.$caminho_foto.'" alt="'.$nome.'">';
		}
	}
	
	if($this->PaginaAux[0] == 'deletar'){
		$id = $this->PaginaAux[1];
		$result = $banco->DeletarParceiro($id);
		if($result){
			$banco->RedirecionaPara('lista-parceiros');
		}
	}
	
	if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
		$nome = strip_tags(trim(addslashes($_POST["nome"])));
		$telefone = strip_tags(trim(addslashes($_POST["telefone"])));
		$foto = $_FILES["foto"];
		
		if($botao == 'Salvar'){
			if($foto){
				$ultimoid = $banco->BuscaMaxId();
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
				$caminho_foto = "arq/parceiros/".$ultimoid.'.'.$ext[1];
				move_uploaded_file($foto["tmp_name"], $caminho_foto);
				
				$banco->SalvaParceiro($nome,$telefone,$caminho_foto);
				$banco->RedirecionaPara('lista-parceiros');
			}
		}else{
			if(empty($foto['name'])){
				$banco->AtualizaParceiro($id,$nome,$telefone,$caminho_foto);
			}else{
				if($banco->DeletaFotoAntiga($id)){
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
					$caminho_foto = "arq/parceiros/".$id.'.'.$ext[1];
					move_uploaded_file($foto["tmp_name"], $caminho_foto);
					$banco->AtualizaParceiro($id, $nome, $telefone, $caminho_foto);
				}
			}
		
				$banco->RedirecionaPara('lista-parceiros');
			
		}
	}
	
	#Declara Variaveis
	$msg  = '';
	
	$Conteudo = $banco->CarregaHtml('add-parceiro');
	$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
	$Conteudo = str_replace('<%NOME%>',$nome,$Conteudo);
	$Conteudo = str_replace('<%TELEFONE%>',$telefone,$Conteudo);
	$Conteudo = str_replace('<%IMG%>', $img, $Conteudo);
	$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
	?>