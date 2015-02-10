<?php
	#include das funcoes da tela inico
	include('functions/banco-sobre.php');

	#Instancia o objeto
	$banco = new bancosobre();
	
	#Declara variaveis
	$botao = 'Salvar';
	
	if($banco->VerificaSessaoAdmin()){
		
		if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
			$sobre = strip_tags(trim(addslashes($_POST["sobre"])));
			if($botao == 'Salvar'){
				$result = $banco->SalvarSobre($sobre);
				$banco->RedirecionaPara('admin-sobre');
			}
		}
		
		$sobre = $banco->SelectSobre();
		
		$Conteudo = $banco->CarregaHtml('admin-sobre');
		$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
		$Conteudo = str_replace('<%SOBRE%>', $sobre, $Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
	
?>