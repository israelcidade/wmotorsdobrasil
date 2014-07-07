<?php
	class bancomarca extends banco{
		#Funcao que lista os Folders
		function ListaMarcas($Auxilio){
			$Banco_Vazio = "Banco esta Vazio";
			#Query Busca Folders
			$Sql = "SELECT * FROM c_marcas";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);

			#Monta no Html a Listagem
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$Linha = $Auxilio;
					$Linha = str_replace('<%ID%>',$rs['idmarca'],$Linha);
					$Linha = str_replace('<%MARCA%>',$rs['marca'],$Linha);
					$Linha = str_replace('<%FOTO%>',$rs['foto'],$Linha);
					$Marcas .= $Linha;
				}
			}else{
				$mensagem = $Banco_Vazio;
			}
			return $Marcas;
		}

		function BuscaMarca($id){
			$Sql = "Select * from c_marcas where idmarca = ".$id;
			$result = $this->Execute($Sql);
			return $result;
		}

		function DeletaMarca($id){
			$flag = $this->DeletaFotoAntiga($id);
			$Sql = "Delete from c_marcas where idmarca = ".$id;
			$result = $this->Execute($Sql);
		}

		#Funcao que deleta a antiga foto
		function DeletaFotoAntiga($id)
		{
			$Sql = "SELECT foto FROM c_marcas where idmarca = '".$id."'";
			if($result = parent::Execute($Sql)){
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				$caminho_foto = $rs['foto'];
				unlink($caminho_foto);
				return true;
			}else{
				return false;
			}
		}

		#Funcao que busca auto_increment da tabela c_folders
		function BuscaMaxId()
		{
			$Sql = "SHOW TABLE STATUS LIKE 'c_marcas'";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			return $rs['Auto_increment'];
		}

	}
?>