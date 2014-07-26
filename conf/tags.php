<?php
	#Definições do Sistema
	date_default_timezone_set('America/Sao_Paulo');
	define('UrlPadrao' , "http://localhost/wmotorsdobrasil/");
	
	#Definições do Banco de Dados
	define('DB_Host' , "localhost");
	define('DB_Database' , "wmotorsdobrasil");
	define('DB_User' , "root");
	define('DB_Pass' , "");
	
	#Definições FPDF
	define('DPI', 96);
	define('MM_IN_INCH', 25.4);
	define('A4_HEIGHT', 210);
	define('A4_WIDTH', 297);

	// tweak these values (in pixels)
	define('MAX_WIDTH', 500);
	define('MAX_HEIGHT', 500);

	//Definicoes do Eamil para contato
	define('EMAIL_USER', "israelcbj@gmail.com");
	define('EMAIL_PASS', "senha email");
	define('EMAIL_RECEB', "israelcbj@gmail.com");

	//Define mensagens de erro
	define('ERRO_ZERO_MARCAS','Nenhuma Marca Cadastrada!');
	define('MSG_ERRO_MARCA_CADASTRADA','Marca ja cadastrada!');
	define('MSG_ERRO_SENHA_DIFERENTE','Senhas diferentes');
	define('MSG_ERRO_CPF_EXISTENTE','Ja possuimos um cadastro com esse cpf');
	define('MSG_ERRO_BANCO','Falha ao conectar no banco de dados, tente novamente mais tarde!');
?>