<?php
	include('../../functions/banco.php');
	include('../../conf/tags.php');
	$banco = new banco;
	$banco->Conecta();

	$id = $_POST['id'];
	$Sql = "Delete from c_marcas where idmarca = '".$id."' ";

	if($result = $banco->Execute($Sql)){
		$flag = $banco->DeletaFotoAntiga($id);
		echo true;
	}else{
		echo false;
	}
?>