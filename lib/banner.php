<?php
	#include das funcoes da tela inico
	include('functions/banco-banner.php');

	#Instancia o objeto
	$banco = new bancobanner();

	#Declara Variaveis
	$botao = 'Salvar';
	$nome = '';

	#Trabalha com Post
	if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
		$nome = strip_tags(trim(addslashes($_POST["nome"])));
		$foto = $_FILES["foto"];

		preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
		$caminho_foto = "arq/banners/" . $id . "teste." .$ext[1];
		move_uploaded_file($foto["tmp_name"], $caminho_foto);
		

		
	}

	$Conteudo = $banco->CarregaHtml('banner');
	$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
	$Conteudo = str_replace('<%NOME%>',$nome,$Conteudo);
?>