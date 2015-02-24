<?php
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();

	$idmarca = $_POST['marca'];
	$Veiculos = '<option value = 0> Modelo ';
	
	if($banco->VerificaSessao()){
		$Sql = "Select * from c_veiculos where marca = '".$idmarca."'";
		$result = $banco->Execute($Sql);
		
		while($rs = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$Linha = "<option value= '".$rs['modelo']."'> ".$rs['modelo']." </option>";
			$Veiculos .= $Linha;
			
		}
	}else{
		$Veiculos .= '<option value="1">Você precisa estar logado para visualizar!</option>';
	}

	echo $Veiculos;
?>