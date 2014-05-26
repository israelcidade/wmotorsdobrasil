<?php
	#Include nas funcoes do folder
	include('functions/banco-usuario.php');

	#Instancia objeto que vai tratar o banco de dados dessa pagina
	$banco = new bancousuario();

	#Carrega o html de Auxilio
	$Auxilio = $banco->CarregaHtml('itens/lista-usuarios-itens');

	#Chama funcao Lista Manual passando o Auxilio
	$Usuarios = $banco->ListaUsuarios($Auxilio);

	#Imprime Valores
	$Conteudo = $banco->CarregaHtml('lista-usuarios');
	$Conteudo = str_replace('<%USUARIOS%>',$Usuarios,$Conteudo);
?>