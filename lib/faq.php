<?php
	#include das funcoes da tela inico
	include('functions/banco-faq.php');

	#Instancia o objeto
	$banco = new bancofaq();
	
	//if($banco->VerificaSessao()){
		#Declara Variaveis
		$msg  = '';
		
		if($this->PaginaAux[0] == 'exportar'){
			$result = $banco->ExportarEmails();
			if($result){
				$banco->Download();
			}
			$banco->RedirecionaPara('admin');
		}
	
		$Conteudo = $banco->CarregaHtml('faq');
		$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
		$Conteudo = str_replace('<%URLPADRAO%>',UrlPadrao,$Conteudo);
	//}else{
	//	$banco->RedirecionaPara('inicio/acesso');
	//}
