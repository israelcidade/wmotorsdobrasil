<?php
	class bancobusca extends banco{
		#Funcao que lista os Folders

		function ListaResultado($Auxilio,$categoria){
			$Sql = "Select V.*,C.* 
					FROM c_veiculos V
					INNER JOIN fixo_categorias C ON C.categoria = '".$categoria."'";
					
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);

			#Monta no Html a Listagem
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$Linha = $Auxilio;
					$Linha = str_replace('<%ID%>',$rs['idveiculo'],$Linha);
					$Linha = str_replace('<%MARCA%>',$rs['nomedamarca'],$Linha);
					$Linha = str_replace('<%MODELO%>', $rs['modelo'], $Linha);
					$Resultado .= $Linha;
				}
			}else{
				$mensagem = $Banco_Vazio;
			}
			return $Resultado;
		}
	}
?>