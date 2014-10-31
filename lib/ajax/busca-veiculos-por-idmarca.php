<?php
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();

	$idmarca = $_POST['marca'];
	$Veiculos = '<option value = 0> Nome ';
	
	$Sql = "Select * from c_veiculos where marca = '".$idmarca."'";
	$result = $banco->Execute($Sql);
	//<option value="ILR EVOQUE DYNAMIC 3D">ILR EVOQUE DYNAMIC 3D</option>
	while($rs = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$Linha = "<option value= '".$rs['modelo']."'> ".$rs['modelo']." </option>";
		$Veiculos .= $Linha;
		
	}

	echo $Veiculos;
?>