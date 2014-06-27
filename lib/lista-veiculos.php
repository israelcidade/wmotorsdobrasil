<?php
	#Include nas funcoes do folder
	include('functions/banco-veiculo.php');

	#Instancia objeto que vai tratar o banco de dados dessa pagina
	$banco = new bancoveiculo();

	if($banco->VerificaSessao()){

		#Carrega o html de Auxilio
		$Auxilio = $banco->CarregaHtml('itens/lista-veiculos-itens');

		#Chama funcao Lista Manual passando o Auxilio
		$Veiculos = $banco->ListaVeiculos($Auxilio);

		#Imprime Valores
		$Conteudo = $banco->CarregaHtml('lista-veiculos');
		$Conteudo = str_replace('<%VEICULOS%>',$Veiculos,$Conteudo);
	}else{
		
		$banco->RedirecionaPara('inicio/acesso');
	}
?>