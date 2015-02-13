<?php
	#include das funcoes da tela inico
	include('functions/banco-busca.php');

	#Instancia o objeto
	$banco = new bancobusca();

	if($banco->VerificaSessao()){

		if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'busca-chassi'){
			$valor = strip_tags(trim(addslashes($_POST["chassi"])));
			$flag = 'chassi';

			#Chama funcao Lista Manual passando o Auxilio
			$Busca = $banco->ListaResultado($flag,$valor);
		}

		if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'global'){
			$valor = strip_tags(trim(addslashes($_POST["busca"])));
			$flag = 'global';

			#Chama funcao Lista Manual passando o Auxilio
			$Busca = $banco->ListaResultado($flag,$valor);
		}

		if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'busca-completa'){
			
			foreach ($_POST as $key => $value) {
				$aux[$key] = $_POST[$key];
			}
			
			#Chama funcao Lista Manual passando o Auxilio
			$Busca = $banco->ListaResultadoCompleto($aux);
		}

		/*if($this->PaginaAux[0]){
			$flag = $this->PaginaAux[0];
			$valor = $this->PaginaAux[1];
			$Busca = $banco->ListaResultado($flag,$valor);
		}*/

		#Imprime Valores
		
		$Conteudo = $banco->CarregaHtml('busca');
		$Conteudo = str_replace('<%BUSCA%>',$Busca,$Conteudo);

	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
	
?>