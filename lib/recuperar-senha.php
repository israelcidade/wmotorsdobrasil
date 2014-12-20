<?php
	#include das funcoes da tela inico
	include('functions/banco-recuperar-senha.php');

	#Instancia o objeto
	$banco = new bancorecuperarsenha();

	#Declara Variaveis
	$msg  = '';
	
	#Trabalha com Post
	if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
		$email = $_POST['email'];
			
		if($result = $banco->EnviarEmailRecuperarSenha($email)){
			$msg = $banco->MontaMsg('ok', 'Verifique seu Email.');
		}else{
			$msg = $banco->MontaMsg('erro', 'Esse email não existe em nossos registros.');
		}
		
		
	}
	
	if($this->PaginaAux[0] == 'codigo'){
		$codigo = $this->PaginaAux[1];
		
		if($banco->AtualizaSenha($codigo)){
			$msg = $banco->MontaMsg('ok', 'Sua nova senha é: '.$codigo);
		}
	}

	$Conteudo = $banco->CarregaHtml('recuperar-senha');
	$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
?>