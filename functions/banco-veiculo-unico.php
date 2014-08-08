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
				$count = 1;
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					if($rs['referencia'] != 0){
						$Linha = $Auxilio;
						$Linha = str_replace('<%COUNT%>',$count,$Linha);
						$Linha = str_replace('<%IDVEICULO%>',$rs['idveiculo'],$Linha);
						$Linha = str_replace('<%CAMINHO%>',$rs['caminho'],$Linha);
						$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
						$Linha = str_replace('<%DESCRICAO%>',$rs['descricao'],$Linha);
						$Veiculos .= $Linha;
						$count = $count + 1;
					}
				}
			}
			return $Veiculos;		
		}

		function BuscaTextosVeiculos($id){
			$Auxilio = $this->CarregaHtml('itens/lista-textos-veiculo-unico-itens');
			$Sql = "Select * from c_fotos where idveiculo = '".$id."'";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			if ($num_rows){
				$count = 0;
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$Linha = $Auxilio;
					$Linha = str_replace('<%COUNT%>',$count,$Linha);
					$Linha = str_replace('<%IDVEICULO%>',$rs['idveiculo'],$Linha);
					$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
					$Linha = str_replace('<%TITULO%>',$rs['titulo'],$Linha);
					$Linha = str_replace('<%DESCRICAO%>',$rs['descricao'],$Linha);
					$Veiculos .= $Linha;
					$count = $count + 1;
				}
			}
			return $Veiculos;
		}
	}
?>