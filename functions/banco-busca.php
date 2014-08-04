<?php
	class bancobusca extends banco{
		#Funcao que lista os Folders

		function ListaResultado($Auxilio,$flag,$valor){
			if($flag == 'categoria'){
				if($valor == 'carro'){
					$valor = '4';
				}elseif($valor == 'moto'){
					$valor = '2';
				}elseif($valor == 'caminhao'){
					$valor = '3';
				}
				$Sql = "SELECT V.*, M.marca as nomemarca
					FROM c_veiculos V 
					INNER JOIN c_marcas M ON v.marca = m.idmarca
					AND v.categoria = '".$valor."'
				";
			}elseif($flag == 'chassi'){
				$Sql = "SELECT V.*, M.marca as nomemarca
					FROM c_veiculos V 
					INNER JOIN c_marcas M where V.padrao = '".$valor."'
				";
			}
			
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

		function ListaResultadoCompleto($Auxilio,$aux){
			var_dump($aux);
			die;

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
					$Resultado .= $Linha;
				}
			}else{
				return $msg = $this->MontaMsg('atencao',ERRO_ZERO_VEICULOS_ENCONTRADOS);
			}
			return $Resultado;
		}
	}
?>