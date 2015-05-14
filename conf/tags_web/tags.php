<?php
	#Defini��es do Sistema
	date_default_timezone_set('America/Sao_Paulo');
	define('UrlPadrao' , "http://www.wmotorsdobrasil.com.br/");
	
	#Defini��es do Banco de Dados
	define('DB_Host' , "mysql.hostinger.com.br");
	define('DB_Database' , "u570752873_wm");
	define('DB_User' , "u570752873_wm");
	define('DB_Pass' , "0EopWbtJD9");
	
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
	define('EMAIL_RECEB', "wmotorsdobrasil@gmail.com");
	define('EMAIL_RECEB_TESTE', "israelcbj@gmail.com");

	//Define mensagens de erro
	define('ERRO_ZERO_MARCAS','Nenhuma Marca Cadastrada!');
	define('ERRO_ZERO_LOGS','Nenhuma Log Encontrado!');
	define('ERRO_ZERO_VEICULOS','Nenhuma Ve&iacute;culo Cadastrado!');
	define('ERRO_ZERO_VEICULOS_ENCONTRADOS','Nenhum Ve&iacute;culo Encontrado!');

	define('MSG_ERRO_ACESSO','Voce nao tem permissao para acessar esta pagina!');
	define('MSG_ERRO_ACESSO_PAGAMENTO','Pagamento Pendente!');
	define('MSG_ERRO_ACESSO_NEGADO','Voc&ecirc; precisa estar logado para acessar esta p&aacute;gina!');
	define('MSG_ERRO_MARCA_CADASTRADA','Marca ja cadastrada!');
	define('MSG_ERRO_SENHA_DIFERENTE','Senhas diferentes');
	define('MSG_ERRO_CPF_EXISTENTE','Ja possuimos um cadastro com esse cpf');
	define('MSG_ERRO_BANCO','Falha ao conectar no banco de dados, tente novamente mais tarde!');
	
	//Senhas
	define('MSG_SENHA_ATUALIZADA','Senha atualizada com sucesso!');
	define('MSG_ERRO_SENHA_IGUAL','Senha antiga é diferente a sua senha atual!');
	define('MSG_ERRO_SENHA_DIFERENTE_ATT','Nova senha é diferente da confirmação de senha!');
?>