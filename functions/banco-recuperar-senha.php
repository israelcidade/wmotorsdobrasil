<?php
	class bancorecuperarsenha extends banco{
		#Funcao que lista os Folders
		
		function EnviarEmailRecuperarSenha($email){
			#Carrega classe MAILER
			include_once("../../app/PHPMailer/class.phpmailer.php");
			include("../../app/PHPMailer/class.smtp.php");
			
			//Gerar codigo
			if($usuario = $this->buscaUsuarioPorEmail($email)){
				$codigo = $this->geraSenha('10',false,false,false);
				
				//Salva codigo no banco com o id do usuario
				$SqlSalvaCodigo = "Insert into c_codigos (idusuario,codigo) VALUES ('".$usuario['idusuario']."', '".$codigo."')";
				$reuulstInter = $this->Execute($SqlSalvaCodigo);
				
				$mail = new PHPMailer();
				// Charset para evitar erros de caracteres
				$mail->Charset = 'UTF-8';
				// Dados de quem est� enviando o email
				$mail->From = 'contato@wmotorsdobrasil.com';
				$mail->FromName = 'wmotorsdobrasil';
					
				// Setando o conteudo
				$mail->IsHTML(true);
				$mail->Subject = 'WmotorsDoBrasil -> Recuperação de Senha';
				$mail->Body = utf8_decode(
						'Clique no link a baixo para recuperar sua senha.<br>
					<a href="'.UrlPadrao.'recuperar-senha/codigo/$codigo">$codigo</a>'
				);
					
				// Validando a autentica��o
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->Host     = "ssl://smtp.gmail.com";
				$mail->Port     = 465;
				$mail->Username = EMAIL_USER;
				$mail->Password = EMAIL_PASS;
					
				// Setando o endere�o de recebimento
				$mail->AddAddress(EMAIL_RECEB);
					
				// Enviando o e-mail para o usu�rio
				if($mail->Send()){
					echo 'ok';
				}else{
					echo 'false';
				}	
			}else{
				echo 'false';
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