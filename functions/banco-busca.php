<?php
	class bancobusca extends banco{
		#Funcao que lista os Folders

		function ListaResultado($flag,$valor){
			if($flag == 'categoria'){
				if($valor == 'carro'){
					$valor = '4';
				}elseif($valor == 'moto'){
					$valor = '2';
				}elseif($valor == 'caminhao'){
					$valor = '3';
				}
				$Sql = "select V.*, M.marca as nomemarca,F.*
					from c_veiculos V 
					inner join c_marcas M ON V.marca = M.idmarca
					inner join c_fotos F ON V.idveiculo = F.idveiculo
					WHERE V.categoria = '".$valor."'
					AND F.referencia = 0
				";
			}elseif($flag == 'chassi'){
				$Sql = "select V.*, M.marca as nomemarca,F.*
					from c_veiculos V 
					inner join c_marcas M ON V.marca = M.idmarca
					inner join c_fotos F ON V.idveiculo = F.idveiculo
					where V.padrao = '".$valor."'
					AND F.referencia = 0
				";
				
			}elseif($flag == 'marca'){
				$Sql = "select V.*, M.marca as nomemarca,F.*
					from c_veiculos V 
					inner join c_marcas M ON V.marca = M.idmarca
					inner join c_fotos F ON V.idveiculo = F.idveiculo
					where V.marca = '".$valor."'
					AND F.referencia = 0
				";
				
			}elseif($flag == 'global'){
				$Sql = "Select V.*, M.marca as nomemarca,F.*
					from c_veiculos V 
					inner join c_marcas M ON V.marca = M.idmarca
					inner join c_fotos F ON V.idveiculo = F.idveiculo
					where M.marca LIKE '%".$valor."%'
					OR V.modelo LIKE '%".$valor."%'
					OR V.anofab LIKE '%".$valor."%'
					OR V.anomod LIKE '%".$valor."%'
					OR V.padrao LIKE '%".$valor."%'
					AND F.referencia = 0
					Group by V.idveiculo
				";
			}
			
			
			$Auxilio = $this->CarregaHtml('itens/lista-busca-itens');
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
					$Linha = str_replace('<%URLPADRAO%>',UrlPadrao, $Linha);
					$Linha = str_replace('<%CAMINHO%>', $rs['caminho'], $Linha);
					$Resultado .= $Linha;
				}
			}else{
				return $msg = $this->MontaMsg('atencao',ERRO_ZERO_VEICULOS_ENCONTRADOS);
			}
			return $Resultado;
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

		function ListaResultadoCompleto($aux){
			
			if($aux['categoria']){
				$categoria = "AND v.categoria = '".$aux['categoria']."' ";
			}
			if($aux['marca']){
				$marca = "AND v.marca = '".$aux['marca']."'";
			}
			if($aux['modelo']){
				$marca = "AND v.modelo = '".$aux['modelo']."'";
			}
			if($aux['anofab']){
				$fabri = "AND v.anofab = '".$aux['anofab']."'";
			}
			if($aux['anomod']){
				$mod = "AND v.anomod = '".$aux['anomod']."'";
			}
			$Sql = "SELECT V.*, M.marca as nomemarca, F.*
					FROM c_veiculos V 
					INNER JOIN c_marcas M ON v.marca = m.idmarca
					INNER JOIN c_fotos F on v.idveiculo = f.idveiculo
					Where f.referencia = 0
					".$categoria."
					".$marca."
					".$modelo."
					".$fabri."
					".$mod."
					";
			
			$Auxilio = $this->CarregaHtml('itens/lista-busca-itens');
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
					$Linha = str_replace('<%CAMINHO%>', $rs['caminho'], $Linha);
					$Resultado .= $Linha;
				}
			}else{
				return $msg = $this->MontaMsg('atencao',ERRO_ZERO_VEICULOS_ENCONTRADOS);
			}
			return $Resultado;
		}
	}
?>