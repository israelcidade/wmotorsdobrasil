<?php
	class bancoinicio extends banco{
		
		function BuscaUsuario($cpf,$senha){
			$Sql = "Select * from c_usuarios where cpf = '".$cpf."' AND senha = '".$senha."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}

		function CarrosEmDestaque(){
			$Sql = "Select V.*,M.marca as nomedamarca,F.*
					FROM c_veiculos V
					INNER JOIN c_marcas M ON V.marca = M.idmarca
					INNER JOIN c_fotos F ON V.idveiculo = F.idveiculo
					AND F.referencia = 0 
					AND V.destaque = 1
					Order by V.idveiculo 
					";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			$Auxilio = $this->CarregaHtml('itens/lista-carros-em-destaque-itens');
			if($num_rows){
				while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
					$Linha = $Auxilio;
					$Linha = str_replace('<%IDVEICULO%>', $rs['idveiculo'], $Linha);
					$Linha = str_replace('<%URLPADRAO%>', UrlPadrao , $Linha);
					$Linha = str_replace('<%CAMINHO%>', $rs['caminho'], $Linha);
					$Carros .= $Linha;
				}
			}
			
			return $Carros;
		}

		function BuscaMarcas(){
			$Sql = "Select * from c_marcas";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			$Auxilio = $this->CarregaHtml('itens/lista-marcas-inicio-itens');
			if($num_rows){
				while($rs = mysql_fetch_array($result , MYSQL_ASSOC)){
					$Linha = $Auxilio;
					$Linha = str_replace('<%IDMARCA%>', $rs['idmarca'], $Linha);
					$Linha = str_replace('<%CAMINHO%>', $rs['foto'], $Linha);
					$Linha = str_replace('<%URLPADRAO%>', UrlPadrao, $Linha);
					$Marcas .= $Linha;
				}
			}
			return $Marcas;	
		}
	}
?>