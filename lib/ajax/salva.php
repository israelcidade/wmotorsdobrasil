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

	
	if($banco->validaCPF($cadastro['cpf'])){
		//Busca no banco o cpf cadastrado
		if($banco->BuscaCpf($cadastro['cpf'])){
			echo 'cpf-cadastrado';
		}else{
			$result = $banco->Execute($Sql);
			if($result){
		            if($banco->EnviaEmailCadastro()){
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