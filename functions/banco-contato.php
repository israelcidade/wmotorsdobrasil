<?php
	class bancocontato extends banco{
		
		function EnviaEmailContato($nome,$email,$assunto,$mensagem){
            #Carrega classe MAILER
			include_once("./app/PHPMailer/class.phpmailer.php");
			include("./app/PHPMailer/class.smtp.php");

			$mail = new PHPMailer();
			// Charset para evitar erros de caracteres
			$mail->Charset = 'UTF-8';
			// Dados de quem está enviando o email
			$mail->From = $email;
			$mail->FromName = $nome;

			// Setando o conteudo
			$mail->IsHTML(true);
			$mail->Subject = 'IMPORTANTE - Contato do site WmotorsdoBrasil';
			
			$monta_mensagem = "
							   Esse contato foi gerado a partir do site WmotorsdoBrasil.com.br.<br><br>
							   
							   Nome: $nome <br>
			                   Email: $email <br>
							   Assunto: $assunto <br>
							   Mensagem: $mensagem <br><br><br>
							   
							   Para responder esse contato copie o email e clique em Novo Email.
								";
			$mail->Body = utf8_decode($monta_mensagem);
            
            // Validando a autenticação
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host     = "ssl://smtp.gmail.com";
			$mail->Port     = 465;
			$mail->Username = EMAIL_USER;
			$mail->Password = EMAIL_PASS;

			// Setando o endereço de recebimento
			$mail->AddAddress(EMAIL_RECEB_TESTE);
            
			// Enviando o e-mail para o usuário
            if($mail->Send()){
                echo "<script>alert('Mensagem Enviada com Sucesso! Aguarde Nosso Retorno.');</script>";
            }else{
				echo "Mailer Error: " . $mail->ErrorInfo;
                echo "<script>alert('Falha ao enviar o email! Tente novamente mais tarde.');</script>";
            }
        }
	}
?>