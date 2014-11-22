<?php
include('../../functions/banco.php');
include('../../conf/tags.php');
$banco = new banco;
$banco->Conecta();

$idcategoria = $_POST['categoria'];
$Marcas = '<option value = 0> Marca ';

$Sql = "Select marca from c_veiculos where categoria = '".$idcategoria."' group by marca";
$result = $banco->Execute($Sql);

while($rs = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$SqlNomeMarca = "Select marca as marca_nome from c_marcas where idmarca = '".$rs['marca']."' ";
	$resultNomeMarca = $banco->Execute($SqlNomeMarca);
	$rsNomeMarca = mysql_fetch_array($resultNomeMarca, MYSQL_ASSOC);
	
	
	$Linha = "<option value= '".$rs['marca']."'> ".$rsNomeMarca['marca_nome']." </option>";
	$Marcas .= $Linha;

}

echo $Marcas;
?>