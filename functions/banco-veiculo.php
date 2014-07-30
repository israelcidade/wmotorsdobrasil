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
			$categorias = '<select name="categoria">';
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

		function InsereVeiculo($arr){
			$Sql = "Insert into c_veiculos (categoria,marca,modelo,anofab,anomod,padrao) 
			VALUES ('".$arr['categoria']."','".$arr['marca']."','".$arr['modelo']."','".$arr['anofab']."','".$arr['anomod']."','".$arr['padrao']."')";
			if($this->Execute($Sql)){
				return true;
			}else{
				return false;
			}
		}

		function InsereImagens($arrImagens){
			$idveiculo = $this->BuscaMaxId();
			
			for ($i=0; $i <= 9 ; $i++) { 
				$fotos[] = array(
					'name' => $arrImagens['name'][$i], 
					'type' => $arrImagens['type'][$i], 
					'tmp_name' => $arrImagens['tmp_name'][$i], 
					'error' => $arrImagens['error'][$i]
				);
			}
			
			for ($i=0; $i <= 9 ; $i++) { 

				if($fotos[$i]['name'] != ''){
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $fotos[$i]["name"], $ext);
					$caminho_foto = "arq/veiculos/".$idveiculo.'/'.md5(uniqid(time())).'.'.$ext[1];
					move_uploaded_file($fotos[$i]["tmp_name"], $caminho_foto);
					$SqlBanco = "Insert Into c_fotos (idveiculo, referencia, caminho, titulo, descricao) 
					VALUES ('".$idveiculo."','".$i."','".$caminho_foto."','".$arr['imagem-title']."','".$arr['imagem-desc']."')";
					$this->Execute($SqlBanco);
				}

			}
		}

		function BuscaMaxId()
		{
			$Sql = "SHOW TABLE STATUS LIKE 'c_veiculos'";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			return $rs['Auto_increment']-1;
		}

		function MontaImagemPrincipal($idveiculo){
			$Sql = "Select * from c_fotos where idveiculo = '".$idveiculo."' AND referencia = 0";
			$result = $this->Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);

			$Auxilio = $this->CarregaHtml('itens/imagem-veiculo-itens');

			if($rs['caminho'] != ''){
				$Auxilio = str_replace('<%FOTO%>','<img src="'.UrlPadrao.'<%FOTO%>">',$Auxilio);
			}else{
				$Auxilio = str_replace('<%FOTO%>','',$Auxilio);
			}

			$Auxilio = str_replace('<%LEGEND%>','Principal',$Auxilio);
			$Auxilio = str_replace('<%FOTO%>',$rs['caminho'],$Auxilio);
			$Auxilio = str_replace('<%URLPADRAO%>',UrlPadrao,$Auxilio);
			return $Auxilio;
		}
	}
?>
