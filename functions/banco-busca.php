<?php
	class bancobusca extends banco{
		#Funcao que lista os Folders

		function ListaResultado($Auxilio,$categoria){

			if($categoria == 'carro'){
				$categoria = '4';
			}elseif($categoria == 'moto'){
				$categoria = '2';
			}elseif($categoria == 'caminhao'){
				$categoria = '3';
			}

			$Sql = "SELECT V.*, M.marca as nomemarca
					FROM c_veiculos V 
					INNER JOIN c_marcas M ON v.marca = m.idmarca
					AND v.categoria = '".$categoria."'
					";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);

			#Monta no Html a Listagem
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$Linha = $Auxilio;
					$Linha = str_replace('<%ID%>',$rs['idveiculo'],$Linha);
					$Linha = str_replace('<%MARCA%>',$rs['nomemarca'],$Linha);
					$Linha = str_replace('<%MODELO%>', $rs['modelo'], $Linha);
					$Linha = str_replace('<%ANOFAB%>', $rs['anofab'], $Linha);
					$Linha = str_replace('<%ANOMOD%>', $rs['anomod'], $Linha);
					$Resultado .= $Linha;
				}
			}else{
				$mensagem = $Banco_Vazio;
			}
			return $Resultado;
		}
	}
?>