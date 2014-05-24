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

		function MontaSelectMarcas($marca){
			$marcas = '<select name="marcas">';
			$marcas .= '<option value="0">Selecione uma Marca</option>';
			$Sql = "Select idmarca , marca from c_marcas";
			$result = parent::Execute($Sql);
			while($aux = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$selected = '';
				if($marca == $aux['idmarca']){
					$selected = 'selected';
				}
				$marcas .= '<option value="'.$aux['idmarca'].'" '.$selected.'>'.$aux['marca'].'</option>';
			}
			$marcas .= '</select>';
			return $marcas;	
		}
	}
?>