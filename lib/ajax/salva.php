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
		'email' 			=>   $aux[3],
		'rg' 				=>   $aux[4],
		'cpf' 				=>   $aux[5],
		'cep' 				=>   $aux[6],
		'endereco' 			=>   $aux[7],
		'complemento' 		=>   $aux[8],
		'bairro' 			=>   $aux[9],
		'cidade' 			=>   $aux[10],
		'estado' 			=>   $aux[11]
		);

	

	if($banco->validaCPF($cadastro['cpf'])){
		//Busca no banco o cpf cadastrado
		
		$cpf = str_replace('.', '' , $cadastro['cpf']);
		$cpf = str_replace('-', '' , $cpf);
		$cpf = str_replace('/', '' , $cpf);
		
		$Sql = "Insert into c_usuarios (senha,nome,nascimento,email,rg,cpf,cep,endereco,complemento,bairro,cidade,estado)
			VALUES ('".$cadastro['senha']."',
					'".$cadastro['nome']."',
					'".$cadastro['nascimento']."',
					'".$cadastro['email']."',
					'".$cadastro['rg']."',
					'".$cpf."',
					'".$cadastro['cep']."',
					'".$cadastro['endereco']."',
					'".$cadastro['complemento']."',		
					'".$cadastro['bairro']."',
					'".$cadastro['cidade']."',
					'".$cadastro['estado']."'
					)
			";
		
		if($banco->BuscaCpf($cpf)){
			echo 'cpfcadastrado';
		}elseif($banco->BuscaEmail($cadastro['email'])){
			echo 'emailcadastrado';
		}else{
			$result = $banco->Execute($Sql);
			if($result){
		            if($banco->EnviaEmailCadastro($cadastro['email'])){
		            	echo 'cadastrado';
		            }else{
		            	echo 'erro-email';
		            }
			}else{
				echo 'erro';
			}
		}
	}else{
		echo 'erro-cpf';
	}
?>