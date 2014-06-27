<?php
	#include das funcoes da tela inico
	include('functions/banco-admin.php');

	#Instancia o objeto
	$banco = new bancoadmin();

	//if($banco->VerificaSessao()){
		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('admin');
		$Conteudo = str_replace('<%USUARIO%>',$_SESSION['usuario'],$Conteudo);
	//}else{
	//	$banco->RedirecionaPara('');
	//}
?>