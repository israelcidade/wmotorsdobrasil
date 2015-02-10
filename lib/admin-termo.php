<?php
	#include das funcoes da tela inico
	include('functions/banco-termo.php');

	#Instancia o objeto
	$banco = new bancotermo();
	
	#Declara variaveis
	$botao = 'Salvar';
	
	if($banco->VerificaSessaoAdmin()){
		
		if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
			$termo = $_POST["termo"];
			//$sobre = strip_tags(trim(addslashes($_POST["sobre"])));
			if($botao == 'Salvar'){
				$result = $banco->SalvarTermo($termo);
				$banco->RedirecionaPara('admin-termo');
			}
		}
		
		$termo = $banco->SelectTermo();
		
		$Conteudo = $banco->CarregaHtml('admin-termo');
		$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
		$Conteudo = str_replace('<%TERMO%>', $termo, $Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
	
?>