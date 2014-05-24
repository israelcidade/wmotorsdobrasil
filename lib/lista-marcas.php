<?php
	#Include nas funcoes do folder
	include('functions/banco-marca.php');

	#Instancia objeto que vai tratar o banco de dados dessa pagina
	$banco = new bancomarca();

	#Carrega o html de Auxilio
	$Auxilio = $banco->CarregaHtml('itens/lista-marcas-itens');

	#Chama funcao Lista Manual passando o Auxilio
	$Marcas = $banco->ListaMarcas($Auxilio);

	#Imprime Valores
	$Conteudo = $banco->CarregaHtml('lista-marcas');
	$Conteudo = str_replace('<%MARCAS%>',$Marcas,$Conteudo);
?>