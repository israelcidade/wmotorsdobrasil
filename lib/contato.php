<?php
	#include das funcoes da tela inico
	include('functions/banco-contato.php');

	#Instancia o objeto
	$banco = new bancocontato();

	if(isset($_POST['acao']) && $_POST['acao'] != ''){
		$nome = strip_tags(trim(addslashes($_POST["nome"])));
		$email = strip_tags(trim(addslashes($_POST["email"])));
		$assunto = strip_tags(trim(addslashes($_POST["assunto"])));
		$mensagem = strip_tags(trim(addslashes($_POST["mensagem"])));

		$banco->EnviaEmailContato($nome,$email,$assunto,$mensagem);
	}

	$Conteudo = $banco->CarregaHtml('contato');
?>