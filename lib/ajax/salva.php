<?php 
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();

	$arr = $_POST['array'];

	$aux = explode('|', $arr);

	$cadastro = array(
		'senha' 			=>   md5($aux[0]),
		'nome' 				=>   $aux[1],
		'nascimento' 		=>   $aux[2],
		'rg' 				=>   $aux[3],
		'cpf' 				=>   $aux[4],
		'cep' 				=>   $aux[5],
		'endereco' 			=>   $aux[6],
		'bairro' 			=>   $aux[7],
		'cidade' 			=>   $aux[8],
		'estado' 			=>   $aux[9]
		);

	$Sql = "Insert into c_usuarios (senha,nome,nascimento,rg,cpf,cep,endereco,bairro,cidade,estado) 
			VALUES ('".$cadastro['senha']."',
					'".$cadastro['nome']."',
					'".$cadastro['nascimento']."',
					'".$cadastro['rg']."',
					'".$cadastro['cpf']."',
					'".$cadastro['cep']."',
					'".$cadastro['endereco']."',
					'".$cadastro['bairro']."',
					'".$cadastro['cidade']."',
					'".$cadastro['estado']."'
					)
			";

	$result = $banco->Execute($Sql);
	if($result){
		#Carrega classe MAILER
			include_once("../../app/PHPMailer/class.phpmailer.php");
			include("../../app/PHPMailer/class.smtp.php");

			$mail = new PHPMailer();
			// Charset para evitar erros de caracteres
			$mail->Charset = 'UTF-8';
			// Dados de quem está enviando o email
			$mail->From = 'contato@wmotorsdobrasil.com';
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
            if($mail->Send()){
            	echo 'ok';
            }
		
	}else{
		echo 'erro';
	}
?>