<?php
	#Include nas funcoes do folder
	include('functions/banco-banner.php');

	#Instancia objeto que vai tratar o banco de dados dessa pagina
	$banco = new bancobanner();

	#Carrega o html de Auxilio
	#$Auxilio = $banco->CarregaHtml('itens/lista-banners-itens');

	#Chama funcao Lista Manual passando o Auxilio
	#$Marcas = $banco->ListaBanners($Auxilio);

	#Imprime Valores
	$Conteudo = $banco->CarregaHtml('lista-banners');
	#$Conteudo = str_replace('<%MARCAS%>',$Marcas,$Conteudo);
?>