<?php
	class bancobanner extends banco{
		#Funcao que lista os Folders
		function ListaBanners($Auxilio){
			$Banco_Vazio = "Banco esta Vazio";
			#Query Busca Folders
			$Sql = "SELECT * FROM c_banners";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);

			#Monta no Html a Listagem
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$Linha = $Auxilio;
					$Linha = str_replace('<%ID%>',$rs['idbanner'],$Linha);
					$Linha = str_replace('<%NOME%>',$rs['nome'],$Linha);
					$Linha = str_replace('<%FOTO%>',$rs['foto'],$Linha);
					$Banners .= $Linha;
				}
			}else{
				$mensagem = $Banco_Vazio;
			}
			return $Banners;
		}

		function BuscaBanner($id){
			$Sql = "Select * from c_banners where idbanner = ".$id;
			$result = $this->Execute($Sql);
			return $result;
		}

		#Funcao que deleta a antiga foto
		function DeletaFotoAntiga($id)
		{
			$Sql = "SELECT foto FROM c_banners where idbanner = '".$id."'";
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
			$Sql = "SHOW TABLE STATUS LIKE 'c_banners'";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			return $rs['Auto_increment'];
		}
		
	}
?>