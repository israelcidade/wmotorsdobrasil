<?php
	class bancoveiculo extends banco{
		#Funcao que lista os Folders
		function ListaVeiculos($Auxilio){
			$Banco_Vazio = "Banco esta Vazio";
			#Query Busca Folders
			$Sql = "SELECT * FROM c_veiculos";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);

			#Monta no Html a Listagem
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$Linha = $Auxilio;
					$Linha = str_replace('<%ID%>',$rs['idveiculo'],$Linha);
					$Linha = str_replace('<%MARCA%>',$rs['marca'],$Linha);
					$Linha = str_replace('<%MODELO%>', $rs['modelo'], $Linha);
					$Veiculos .= $Linha;
				}
			}else{
				$mensagem = $Banco_Vazio;
			}
			return $Veiculos;
		}

		function BuscaVeiculo($id){
			$Sql = "Select * from c_veiculos where idveiculo = ".$id;
			$result = $this->Execute($Sql);
			return $result;
		}

		function DeletaVeiculo($id){
			$Sql = "Delete from c_veiculos where idveiculo = ".$id;
			$result = $this->Execute($Sql);
		}

	}
?>