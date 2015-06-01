<?php
	#Include nas funcoes do folder
	include('functions/banco-parceiros.php');
	
	#Instancia objeto que vai tratar o banco de dados dessa pagina
	$banco = new bancoparceiros();

	if($banco->VerificaSessaoAdmin()){
		
		#Carrega o html de Auxilio
		$Auxilio = $banco->CarregaHtml('itens/lista-parceiros-itens');
			
		#Chama funcao Lista Manual passando o Auxilio
		$Parceiros = $banco->ListaParceiros($Auxilio);

		#Imprime Valores
		$Conteudo = $banco->CarregaHtml('lista-parceiros');
		$Conteudo = str_replace('<%PARCEIROS%>',$Parceiros,$Conteudo);
		
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>