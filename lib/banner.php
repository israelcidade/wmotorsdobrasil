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

		if($botao == 'Atualizar'){
			$SqlBanco = "Update c_veiculos SET marca = '".$marca."', modelo = '".$modelo."',anofab = '".$anofab."',anomod = '".$anomod."',padrao = '".$padrao."',titulo = '".$titulo."' where idveiculo = '".$idveiculo."' ";
		}else{
			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
			$caminho_foto = "arq/banners/" . $id . "teste." .$ext[1];
			move_uploaded_file($foto["tmp_name"], $caminho_foto);
			$SqlBanco = "Insert Into c_banners (nome, foto) VALUES ('".$nome."','".$caminho_foto."')";
		}

		$banco->Execute($SqlBanco);
		$banco->RedirecionaPara('lista-banners');
	}

	$Conteudo = $banco->CarregaHtml('banner');
	$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
	$Conteudo = str_replace('<%NOME%>',$nome,$Conteudo);
?>