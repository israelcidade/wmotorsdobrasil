<?php 
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();

	$arr = $_POST['array'];

	$aux = explode('|', $arr);
	$cadastro = array(
		'senha' 			=>   $aux[0],
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
	
	foreach ($cadastro as $value) {
		if($value == ''){
			echo 'error-campos';
		}
	}
	$result = $banco->Execute($Sql);
	$num_rows = $banco->Linha($result);

	echo 'ok';
?>