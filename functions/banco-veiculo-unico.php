<?php
	class bancoveiculounico extends banco{
		#Funcao que lista os Folders

		function BuscaVeiculoUnico($id){
			$Sql = "Select V.*,M.marca as nomedamarca 
					FROM c_veiculos V
					INNER JOIN c_marcas M where V.idveiculo = '".$id."'
					";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			if($num_rows){
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				$VeiculoUnico['marca'] = $rs['nomedamarca'];
				$VeiculoUnico['modelo'] = $rs['modelo'];
				$VeiculoUnico['anofab'] = $rs['anofab'];
				$VeiculoUnico['anomod'] = $rs['anomod'];
				$VeiculoUnico['padrao'] = $rs['padrao'];
			}
			return $VeiculoUnico;
		}
	}
?>