<?php
	class bancorecuperarsenha extends banco{
		#Funcao que lista os Folders
		
		function EnviarEmailRecuperarSenha($email){
			#Carrega classe MAILER
			include_once("../../app/PHPMailer/class.phpmailer.php");
			include("../../app/PHPMailer/class.smtp.php");
			
			//Gerar codigo
			$codigo = $this->geraSenha('10',false,false,false);
			if($usuario = $this->buscaUsuarioPorEmail($email)){
				
			}else{
				return false;
			}
			
			$mail = new PHPMailer();
			// Charset para evitar erros de caracteres
			$mail->Charset = 'UTF-8';
			// Dados de quem est� enviando o email
			$mail->From = 'contato@wmotorsdobrasil.com';
			$mail->FromName = 'wmotorsdobrasil';
			
			// Setando o conteudo
			$mail->IsHTML(true);
			$mail->Subject = 'WmotorsDoBrasil -> Bem Vindo';
			$mail->Body = utf8_decode(
					'Bem Vindo ao Wmotors do Brasil!<br>
					Realize seu pagamento e come�e a utilizar nosso site para suas pesquisas!'
			);
			
			// Validando a autentica��o
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host     = "ssl://smtp.gmail.com";
			$mail->Port     = 465;
			$mail->Username = EMAIL_USER;
			$mail->Password = EMAIL_PASS;
			
			// Setando o endere�o de recebimento
			$mail->AddAddress($email);
			
			// Enviando o e-mail para o usu�rio
			if($mail->Send()){
				return true;
			}else{
				return false;
			}
		}
		
		function buscaUsuarioPorEmail($email){
			$Sql = "Select * from c_usuarios where email = '".$email."' ";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			if($num_rows){
				$rs = mysql_fetch_array($result, MYSQL_ASSOC);
				return $rs;
			}else{
				return false;
			}
		}
		
	}
?>