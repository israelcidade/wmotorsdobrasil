<?php
	class bancoparceiros extends banco{
		#Funcao que lista os Folder
		
		function SalvaParceiro($nome,$telefone,$caminho){
			$Sql = "Insert into c_parceiros (parceiro_nome,parceiro_telefone,parceiro_foto_caminho) VALUES ('".$nome."', '".$telefone."', '".$caminho."')";
			$result = parent::Execute($Sql);
			if($result){
				return true;
			}else{
				return false;
			}		
		}
		
		function AtualizaParceiro($id,$nome,$telefone,$caminho_foto = NULL){
			$SqlBanco = "Update c_parceiros SET parceiro_nome = '".$nome."',parceiro_telefone = '".$telefone."', parceiro_foto_caminho = '".$caminho_foto."' where parceiro_id = '".$id."' ";
			if(parent::Execute($SqlBanco)){
				return true;
			}else{
				return false;
			}
		}
		
		function DeletarParceiro($id){
			$resultado = $this->BuscaParceiro($id);
			$rs = mysql_fetch_array($resultado , MYSQL_ASSOC);
			
			$Sql = "Delete from c_parceiros where parceiro_id = '".$id."'";
			if(parent::Execute($Sql)){
				unlink($rs['parceiro_foto_caminho']);
				return true;
			}else{
				return false;
			}
		}
		
		function ListaParceiros($Auxilio){
			#Query Busca Folders
			$Sql = "SELECT * FROM c_parceiros";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
		
			#Monta no Html a Listagem
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$Linha = $Auxilio;
					$Linha = str_replace('<%ID%>',$rs['parceiro_id'],$Linha);
					$Linha = str_replace('<%NOME%>',$rs['parceiro_nome'],$Linha);
					$Linha = str_replace('<%TELEFONE%>',$rs['parceiro_telefone'],$Linha);
					$Linha = str_replace('<%FOTO%>',$rs['parceiro_foto_caminho'],$Linha);
					$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
					$Parceiros .= $Linha;
				}
			}else{
				return $msg = $this->MontaMsg('atencao',ERRO_ZERO_MARCAS);
			}
			return $Parceiros;
		}
		
		function BuscaParceiro($id){
			$Sql = "Select * from c_parceiros where parceiro_id = '".$id."' ";
			$result = parent::Execute($Sql);
			return $result;
		}
		
		#Funcao que busca auto_increment da tabela c_folders
		function BuscaMaxId()
		{
			$Sql = "SHOW TABLE STATUS LIKE 'c_parceiros'";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			return $rs['Auto_increment'];
		}
		
		#Funcao que deleta a antiga foto
		function DeletaFotoAntiga($id)
		{
			$Sql = "SELECT * FROM c_parceiros where parceiro_id = '".$id."'";
			if($result = parent::Execute($Sql)){
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				$caminho_foto = $rs['parceiro_foto_caminho'];
				unlink($caminho_foto);
				return true;
			}else{
				return false;
			}
		}
	}
?>