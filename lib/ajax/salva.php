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
		'bairro' 			=>   $aux[8],
		'cidade' 			=>   $aux[9],
		'estado' 			=>   $aux[10]
		);

	$Sql = "Insert into c_usuarios (senha,nome,nascimento,email,rg,cpf,cep,endereco,bairro,cidade,estado) 
			VALUES ('".$cadastro['senha']."',
					'".$cadastro['nome']."',
					'".$cadastro['nascimento']."',
					'".$cadastro['email']."',
					'".$cadastro['rg']."',
					'".$cadastro['cpf']."',
					'".$cadastro['cep']."',
					'".$cadastro['endereco']."',
					'".$cadastro['bairro']."',
					'".$cadastro['cidade']."',
					'".$cadastro['estado']."'
					)
			";

	
	if($banco->validaCPF($cadastro['cpf'])){
		//Busca no banco o cpf cadastrado
		if($banco->BuscaCpf($cadastro['cpf'])){
			echo 'cpf-cadastrado';
		}else{
			$result = $banco->Execute($Sql);
			if($result){
		            if($banco->EnviaEmailCadastro($cadastro['email'])){
		            	echo 'ok';
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