<?php
	#include das funcoes da tela inico
	include('functions/banco-admin.php');

	#Instancia o objeto
	$banco = new bancoadmin();

	//if($banco->VerificaSessao()){
		#Imprimi valores

	if( isset($_POST["acao"]) && $_POST["acao"] != ''){
		$user = strip_tags(trim(addslashes($_POST["user"])));
		$senha = strip_tags(trim(addslashes($_POST["senha"])));

		$flag = $banco->BuscaUsuario($user,$senha);

		if($flag){
			$banco->IniciaSessao($user);
			$banco->RedirecionaPara('lista-veiculos');
		}else{
			$banco->RedirecionaPara('admin');
		}
	}
	$Conteudo = $banco->CarregaHtml('admin');
	//}else{
	//	$banco->RedirecionaPara('');
	//}
?>