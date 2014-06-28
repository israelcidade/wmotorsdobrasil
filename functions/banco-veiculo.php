<?php
	class bancoveiculo extends banco{
		#Funcao que lista os Folders
		function ListaVeiculos($Auxilio){
			$Banco_Vazio = "Banco esta Vazio";
			#Query Busca Folders
			$Sql = "Select V.*,M.marca as nomedamarca 
					FROM c_veiculos V
					INNER JOIN c_marcas M ON V.marca = M.idmarca";
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
			$marcas = '<select name="marca">';
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

		function MontaSelectCategorias($categoria){
			$categorias = '<select name="tipo">';
			$categorias .= '<option value="0">Selecione uma Categoria</option>';
			$Sql = "Select idcategoria , categoria from fixo_categorias";
			$result = parent::Execute($Sql);
			while($aux = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$selected = '';
				if($categoria == $aux['idcategoria']){
					$selected = 'selected';
				}
				$categorias .= '<option value="'.$aux['idcategoria'].'" '.$selected.'>'.$aux['categoria'].'</option>';
			}
			$categorias .= '</select>';
			return $categorias;	
		}
	}
?>