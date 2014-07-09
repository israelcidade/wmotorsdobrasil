<?php
	class bancoinicio extends banco{
		
		function BuscaUsuario($cpf,$senha){
			$Sql = "Select * from c_usuarios where cpf = '".$cpf."' AND senha = '".$senha."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}

		function buscaUltimoVeiculo(){
			$Sql = "Select V.*,M.marca as nomedamarca 
					FROM c_veiculos V
					INNER JOIN c_marcas M
					Order by V.idveiculo DESC LIMIT 1 
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