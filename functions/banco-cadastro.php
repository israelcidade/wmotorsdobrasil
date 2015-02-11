<?php
	class bancocadastro extends banco{
		#Funcao que lista os Folders

		function BuscaCep($cep){
			$resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
			if(!$resultado){  
        		$resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";  
    		}  
    		parse_str($resultado, $retorno);   
    		return $retorno;
		}

		function CadastraUsuario($usuario){
			$Sql = "Insert into c_usuarios (nome,senha,nascimento,email,rg,cpf,cep,endereco,bairro,cidade,estado) VALUES ('".$usuario['nome']."','".$usuario['senha']."','".$usuario['nascimento']."','".$usuario['rg']."','".$usuario['cpf']."','".$usuario['cep']."','".$usuario['endereco']."','".$usuario['bairro']."','".$usuario['cidade']."','".$usuario['estado']."') ";
			
			if($this->BuscaUsuarioPorCpf($usuario['cpf'])){
				return MSG_ERRO_CPF_EXISTENTE;
			}elseif($usuario['senha'] != $usuario['confsenha']){
				return MSG_ERRO_SENHA_DIFERENTE;
			}elseif(!parent::Execute($Sql)){
				return MSG_ERRO_BANCO;
			}else{
				return 'ok';	
			}
		}

		function BuscaUsuarioPorCpf($cpf){
			$Sql = "Select * from c_usuarios where cpf = '".$cpf."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}
		
		function TermoDeUso(){
			$Sql = "Select termo from c_termo where idtermo = 0";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			$termo = $rs['termo'];
			return $termo;
		}

		function EnviaEmailCadastro($mensagem){
            #Carrega classe MAILER
			include_once("./app/PHPMailer/class.phpmailer.php");
			include("./app/PHPMailer/class.smtp.php");

			$mail = new PHPMailer();
			// Charset para evitar erros de caracteres
			$mail->Charset = 'UTF-8';
			// Dados de quem está enviando o email
			$mail->From = 'wmotorsdobrasil';
			$mail->FromName = 'wmotorsdobrasil';

			// Setando o conteudo
			$mail->IsHTML(true);
			$mail->Subject = 'WmotorsDoBrasil -> Bem Vindo';
			$mail->Body = utf8_decode(
				'Bem Vindo ao Wmotors do Brasil!<br>
				Realize seu pagamento e comece a sua pesquisa!'
				);
            
            // Validando a autenticação
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host     = "ssl://smtp.gmail.com";
			$mail->Port     = 465;
			$mail->Username = EMAIL_USER;
			$mail->Password = EMAIL_PASS;

			// Setando o endereço de recebimento
			$mail->AddAddress(EMAIL_RECEB);
            
			// Enviando o e-mail para o usuário
            $mail->Send();
        }
	}
?>