<?php
	class bancoveiculounico extends banco{
		#Funcao que lista os Folders

		function BuscaVeiculoUnico($id){
			$Sql = "Select V.*,M.marca as nomedamarca, F.* 
					FROM c_veiculos V 
					INNER JOIN c_marcas M ON V.marca = M.idmarca 
					INNER JOIN c_fotos F ON V.idveiculo = F.idveiculo 
					where V.idveiculo = '".$id."'
					AND F.referencia = 0
					";
					
					
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			if($num_rows){
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				$VeiculoUnico['idveiculo']   = $rs['idveiculo'];
				$VeiculoUnico['marca']   = $rs['nomedamarca'];
				$VeiculoUnico['modelo']  = $rs['modelo'];
				$VeiculoUnico['anofab']  = $rs['anofab'];
				$VeiculoUnico['anomod']  = $rs['anomod'];
				$VeiculoUnico['caminho'] = $rs['caminho'];
				$VeiculoUnico['padrao']  = $rs['padrao'];
			}
			return $VeiculoUnico;
		}

		function BuscaImagensVeiculo($id){
			$Auxilio = $this->CarregaHtml('itens/lista-imagens-veiculo-unico-itens');
			$Sql = "Select * from c_fotos where idveiculo = '".$id."'";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					if($rs['referencia'] != 0){
						$Linha = $Auxilio;
						$Linha = str_replace('<%ID%>',$rs['idveiculo'],$Linha);
						$Linha = str_replace('<%CAMINHO%>',$rs['caminho'],$Linha);
						$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
						$Veiculos .= $Linha; 
					}
				}
			}
			return $Veiculos;		
		}
	}
?>