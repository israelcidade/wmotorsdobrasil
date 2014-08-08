<?php
	#include das funcoes da tela inico
	include('functions/banco-veiculo-unico.php');

	#Instancia o objeto
	$banco = new bancoveiculounico();

	#Carrega o html de Auxilio
	$Auxilio = $banco->CarregaHtml('itens/lista-veiculo-unico-itens');

	#Chama funcao Lista Manual passando o Auxilio
	$VeiculoUnico = $banco->BuscaVeiculoUnico($this->PaginaAux[0]);

	#Carrega imagens de 1 ate 9
	$ImagensVeiculo = $banco->BuscaImagensVeiculo($this->PaginaAux[0]);

	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('veiculo-unico');
	$Conteudo = str_replace('<%IDVEICULO%>',$VeiculoUnico['idveiculo'],$Conteudo);
	$Conteudo = str_replace('<%MARCA%>',$VeiculoUnico['marca'],$Conteudo);
	$Conteudo = str_replace('<%MODELO%>',$VeiculoUnico['modelo'],$Conteudo);
	$Conteudo = str_replace('<%ANOFAB%>',$VeiculoUnico['anofab'],$Conteudo);
	$Conteudo = str_replace('<%ANOMOD%>',$VeiculoUnico['anomod'],$Conteudo);
	$Conteudo = str_replace('<%PADRAO%>',$VeiculoUnico['padrao'],$Conteudo);
	$Conteudo = str_replace('<%URLPADRAO%>',UrlPadrao,$Conteudo);
	$Conteudo = str_replace('<%CAMINHO%>',$VeiculoUnico['caminho'],$Conteudo);
	$Conteudo = str_replace('<%IMAGENSVEICULO%>',$ImagensVeiculo,$Conteudo);
	
?>