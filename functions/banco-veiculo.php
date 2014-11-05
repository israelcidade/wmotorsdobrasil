<?php
	class bancoveiculo extends banco{
		#Funcao que lista os Folders
		function ListaVeiculos($Auxilio){
			$Banco_Vazio = "Banco esta Vazio";
			#Query Busca Folders
			$Sql = "Select V.*,M.marca as nomedamarca
					FROM c_veiculos V
					INNER JOIN c_marcas M ON V.marca = M.idmarca
					";

			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);

			#Monta no Html a Listagem
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$caminho = $this->BuscaImagemVeiculo($rs['idveiculo']);
					
					$Linha = $Auxilio;
					$Linha = str_replace('<%ID%>',$rs['idveiculo'],$Linha);
					$Linha = str_replace('<%MARCA%>',$rs['nomedamarca'],$Linha);
					$Linha = str_replace('<%MODELO%>',$rs['modelo'],$Linha);
					$Linha = str_replace('<%FOTO%>',UrlPadrao.$caminho,$Linha);
					$Veiculos .= $Linha;
				}
			}else{
				return $msg = $this->MontaMsg('atencao',ERRO_ZERO_VEICULOS);
			}
			return $Veiculos;
		}

		function BuscaImagemVeiculo($id){
			$Sql = "Select caminho from c_fotos where idveiculo = '".$id."' AND referencia = 0";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			if($num_rows){
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				return $rs['caminho'];
			}else{
				$caminho = 'html/style/images/semimagem.jpg';
				return $caminho;
			}
		}

		function BuscaVeiculo($id){
			$Sql = "Select * from c_veiculos where idveiculo = ".$id;
			$result = $this->Execute($Sql);
			return $result;
		}

		function DeletaVeiculo($id){
			$Sql = "Delete from c_veiculos where idveiculo = ".$id;
			$result = $this->Execute($Sql);
			//Criar funcao que deleta a pasta!
			$pasta = "arq/veiculos/".$id;
			$this->removeDirectory($pasta);
		}

		function removeDirectory($dir) {
			$abreDir = opendir($dir);

			while (false !== ($file = readdir($abreDir))) {
				if ($file==".." || $file ==".") continue;
				if (is_dir($cFile=($dir."/".$file))) removeDirectory($cFile);
				elseif (is_file($cFile)) unlink($cFile);
			}
			closedir($abreDir);
			rmdir($dir);
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

		function InsereVeiculo($arr,$botao,$idveiculo){

			if($arr['destaque'] == ''){
				$arr['destaque'] = 0;
			}
			
			$SqlInsert = "Insert into c_veiculos 
			(categoria,marca,modelo,anofab,anomod,padrao,destaque) 
			VALUES ('".$arr['categoria']."','".$arr['marca']."','".$arr['modelo']."','".$arr['anofab']."','".$arr['anomod']."','".$arr['padrao']."','".$arr['destaque']."')";
			
			$SqlUpdate = "Update c_veiculos set 
						categoria = '".$arr['categoria']."', 
						marca = '".$arr['marca']."', 
						modelo = '".$arr['modelo']."',
						anofab = '".$arr['anofab']."',
						anomod = '".$arr['anomod']."',
						padrao = '".$arr['padrao']."',
						destaque = '".$arr['destaque']."'
						where idveiculo = '".$idveiculo."'";

			if($botao == 'Atualizar'){
				$result = $this->Execute($SqlUpdate);
				return true;
			}else{
				$result = $this->Execute($SqlInsert);
				$idveiculo = $this->BuscaMaxId();
				mkdir('arq/veiculos/'.$idveiculo);
				return true;
			}
		}

		function InsereImagens($arrImagens,$arr,$idveiculo){
			include('resize-class.php');

			for ($i=0; $i <= 9 ; $i++) { 
				$fotos[] = array(
					'name' => $arrImagens['name'][$i], 
					'type' => $arrImagens['type'][$i], 
					'tmp_name' => $arrImagens['tmp_name'][$i], 
					'error' => $arrImagens['error'][$i],
					'imagem-title' => $arr['imagem-title'][$i],
					'imagem-desc' => $arr['imagem-desc'][$i]
				);
			}
			
			
			for ($i=0; $i <= 9 ; $i++) {

				$Sql = "Select * from c_fotos where idveiculo = '".$idveiculo."' AND referencia = '".$i."'";
				$result = $this->Execute($Sql);
				$num_rows = $this->Linha($result);
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);

				if($rs['referencia'] != ''){
					$Sql2 = "Update c_fotos set 
						titulo = '".$fotos[$i]["imagem-title"]."', 
						descricao = '".$fotos[$i]["imagem-desc"]."' 
						where idveiculo = '".$idveiculo."' 
						AND referencia = '".$i."'";
						$this->Execute($Sql2);
				}

				if($fotos[$i]['name'] != ''){
					// Carrega a imagem a ser manipulada
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $fotos[$i]["name"], $ext);

					if(move_uploaded_file($fotos[$i]["tmp_name"], 'arq/veiculos/'.$idveiculo.'/'.$fotos[$i]['name'])){
						$resizeObj = new resize('arq/veiculos/'.$idveiculo.'/'.$fotos[$i]['name']);
						$resizeObj -> resizeImage(640, 480, 'crop');
						$resizeObj -> saveImage('arq/veiculos/'.$idveiculo.'/'.$fotos[$i]['name'], 100);
						$caminho_foto = $this->MarcaDagua('arq/veiculos/'.$idveiculo.'/'.$fotos[$i]['name'],$idveiculo,$ext);
						unlink('arq/veiculos/'.$idveiculo.'/'.$fotos[$i]['name']);
					}

					if($num_rows){
						unlink($rs['caminho']);
						$SqlBanco = "Update c_fotos set 
						caminho = '".$caminho_foto."', 
						titulo = '".$fotos[$i]["imagem-title"]."', 
						descricao = '".$fotos[$i]["imagem-desc"]."' 
						where idveiculo = '".$idveiculo."' 
						AND referencia = '".$i."'";
						
					}else{
						$SqlBanco = "Insert Into c_fotos 
						(idveiculo, referencia, caminho, titulo, descricao) 
						VALUES 
						('".$idveiculo."','".$i."',
							'".$caminho_foto."',
							'".$fotos[$i]["imagem-title"]."',
							'".$fotos[$i]["imagem-desc"]."'
						)";
					}

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
				$Auxilio = str_replace('<%FOTO%>','<img src="'.UrlPadrao.$rs['caminho'].'">',$Auxilio);
			}else{
				$Auxilio = str_replace('<%FOTO%>','',$Auxilio);
			}

			$Auxilio = str_replace('<%NUMERACAO%>','',$Auxilio);
			$Auxilio = str_replace('<%TITULO%>',$rs['titulo'],$Auxilio);
			$Auxilio = str_replace('<%DESCRICAO%>',$rs['descricao'],$Auxilio);
			return $Auxilio;
		}

		function MontaImagemChassi($idveiculo){
			$Auxilio = $this->CarregaHtml('itens/imagem-veiculo-itens');
			$j = 1;
			for ($i=1; $i <= 3; $i++) {
				
				$Sql = "Select * from c_fotos where idveiculo = '".$idveiculo."' AND referencia = '".$i."'";
				$result = $this->Execute($Sql);
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);

				$Linha = $Auxilio;

				if($rs['caminho'] != ''){
					$Linha = str_replace('<%FOTO%>','<img src="'.UrlPadrao.$rs['caminho'].'">',$Linha);
				}else{
					$Linha = str_replace('<%FOTO%>','',$Linha);
				}

				$Linha = str_replace('<%NUMERACAO%>','Imagem '.$j,$Linha);
				$Linha = str_replace('<%TITULO%>',$rs['titulo'],$Linha);
				$Linha = str_replace('<%DESCRICAO%>',$rs['descricao'],$Linha);
				$Fotos .= $Linha;

				$j = $j + 1;
			}

			return $Fotos;
		}

		function MontaImagemMotor($idveiculo){
			$Auxilio = $this->CarregaHtml('itens/imagem-veiculo-itens');
			$j = 1;
			for ($i=4; $i <= 6; $i++) {
				
				$Sql = "Select * from c_fotos where idveiculo = '".$idveiculo."' AND referencia = '".$i."'";
				$result = $this->Execute($Sql);
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);

				$Linha = $Auxilio;

				if($rs['caminho'] != ''){
					$Linha = str_replace('<%FOTO%>','<img src="'.UrlPadrao.$rs['caminho'].'">',$Linha);
				}else{
					$Linha = str_replace('<%FOTO%>','',$Linha);
				}

				
				$Linha = str_replace('<%NUMERACAO%>','Imagem '.$j,$Linha);
				$Linha = str_replace('<%TITULO%>',$rs['titulo'],$Linha);
				$Linha = str_replace('<%DESCRICAO%>',$rs['descricao'],$Linha);
				$Fotos .= $Linha;

				$j = $j + 1;
			}

			return $Fotos;
		}

		function MontaImagemCambio($idveiculo){
			$Auxilio = $this->CarregaHtml('itens/imagem-veiculo-itens');
			$j = 1;
			for ($i=7; $i <= 9; $i++) {
				
				$Sql = "Select * from c_fotos where idveiculo = '".$idveiculo."' AND referencia = '".$i."'";
				$result = $this->Execute($Sql);
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);

				$Linha = $Auxilio;

				if($rs['caminho'] != ''){
					$Linha = str_replace('<%FOTO%>','<img src="'.UrlPadrao.$rs['caminho'].'">',$Linha);
				}else{
					$Linha = str_replace('<%FOTO%>','',$Linha);
				}

				$Linha = str_replace('<%NUMERACAO%>','Imagem '.$j,$Linha);
				$Linha = str_replace('<%TITULO%>',$rs['titulo'],$Linha);
				$Linha = str_replace('<%DESCRICAO%>',$rs['descricao'],$Linha);
				$Fotos .= $Linha;

				$j = $j + 1;
			}
			
			return $Fotos;
		}
	}
?>
