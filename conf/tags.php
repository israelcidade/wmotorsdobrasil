<?php
	#Defini��es do Sistema
	date_default_timezone_set('America/Sao_Paulo');
	define('UrlPadrao' , "http://localhost/wmotorsdobrasil/");
	
	#Defini��es do Banco de Dados
	define('DB_Host' , "localhost");
	define('DB_Database' , "wmotorsdobrasil");
	define('DB_User' , "root");
	define('DB_Pass' , "");
	
	#Defini��es FPDF
	define('DPI', 96);
	define('MM_IN_INCH', 25.4);
	define('A4_HEIGHT', 210);
	define('A4_WIDTH', 297);

	// tweak these values (in pixels)
	define('MAX_WIDTH', 500);
	define('MAX_HEIGHT', 500);

	//Definicoes do Eamil para contato
	define('EMAIL_USER', "israelcbj@gmail.com");
	define('EMAIL_PASS', "m4r4n4t4");
	define('EMAIL_RECEB', "israelcbj@gmail.com");
?>