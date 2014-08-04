<?php
	class banco{
		
		#Funcao que inicia conexao com banco
		function Conecta(){	
			$link = mysql_connect(DB_Host,DB_User,DB_Pass);
			if (!$link) {
				$this->ChamaManutencao();
			}
			$db_selected = mysql_select_db(DB_Database, $link);
			if (!$db_selected) {
				$this->ChamaManutencao();
			}
		}

		#Funcao que redireciona para pagina solicitada
		function RedirecionaPara($nome){
			header("Location: ".UrlPadrao.$nome);
		}

		#abre a sessao
		function IniciaSessao($cpf){
			session_start('login');
			$_SESSION['cpf'] = $cpf;
		}

		#fecha sessao
		function FechaSessao(){
			session_start('login');
			$_SESSION = array();
			session_destroy();
		}

		function VerificaSessao(){
			session_start('login');
			if( isset($_SESSION['cpf']) ){
				return true;
			}else{
				return false;
			}
		}

		function MontaMenu(){
			$Sql = "Select * from fixo_menu";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			$class = '';
			while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) ){
				$Linha = $this->CarregaHtml('itens/menu');


				if($this->Pagina == '' && $rs['nome'] == 'Inicial'){
					$Linha = str_replace('<%CLASS%>',"class = 'active'",$Linha);
				}elseif($this->Pagina == $rs['link']){
					$Linha = str_replace('<%CLASS%>',"class = 'active'",$Linha);
				}else{
					$Linha = str_replace('<%CLASS%>','',$Linha);
				}


				$Linha = str_replace('<%LINK%>',$rs['link'],$Linha);
				$Linha = str_replace('<%TITLE%>',$rs['title'],$Linha);
				$Linha = str_replace('<%NOME%>',$rs['nome'],$Linha);
				$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
				$Menu .= $Linha;
			}
			return $Menu;
		}

		function MontaBusca(){
			$Busca = $this->CarregaHtml('itens/busca');
			//Marca e Tipo
			$Marcas = $this->MontaSelectMarcas();
			$Tipo = $this->MontaSelectCategorias();
			$Modelos = $this->MontaSelectModelos();

			$Busca = str_replace('<%MARCAS%>',$Marcas,$Busca);
			$Busca = str_replace('<%TIPO%>',$Tipo,$Busca);
			$Busca = str_replace('<%MODELOS%>',$Modelos,$Busca);
			return $Busca;
		}
		
		#funcao imprime conteudo
		function Imprime($Conteudo){
			if($this->Pagina == 'admin' || $this->Pagina == 'veiculo' || $this->Pagina == 'lista-veiculos' 
				|| $this->Pagina == 'lista-marcas' || $this->Pagina == 'marca' || $this->Pagina == 'lista-usuarios'){
				$SaidaHtml = $this->CarregaHtml('modelo-admin');
			}else{
				$SaidaHtml = $this->CarregaHtml('modelo');	
			}

			$Menu = $this->MontaMenu();
			$Busca = $this->MontaBusca();

			$SaidaHtml = str_replace('<%CONTEUDO%>',$Conteudo,$SaidaHtml);
			$SaidaHtml = str_replace('<%URLPADRAO%>',UrlPadrao,$SaidaHtml);
			$SaidaHtml = str_replace('<%MENU%>',$Menu,$SaidaHtml);
			$SaidaHtml = str_replace('<%BUSCA%>',$Busca,$SaidaHtml);
			echo $SaidaHtml;
		}
		
		#funcao que chama manutencao
		function ChamaManutencao(){
			$filename = 'html/manutencao.html';
			$handle = fopen($filename,"r");
			$Html = fread($handle,filesize($filename));
			fclose($handle);
			$SaidaHtml = $this->CarregaHtml('modelo');
			$SaidaHtml = str_replace('<%CONTEUDO%>',$Html,$SaidaHtml);
			$SaidaHtml = str_replace('<%URLPADRAO%>',UrlPadrao,$SaidaHtml);
			echo $SaidaHtml;
			die;
		}
		
		#funcao que monta o conteudo
		function MontaConteudo(){
			#verifica se nao tem nada do lado da URLPADRAO
			if(!isset($this->Pagina)){
				return $Conteudo = $this->ChamaPhp('inicio');
			#verifica se a pagina existe e chama ela
			}elseif($this->BuscaPagina()){
				return $Conteudo = $this->ChamaPhp($this->Pagina);
			#Se nao tiver pagina chama 404
			}else{
				return $Conteudo = $this->CarregaHtml('404');
			}
		} 
		
		#Busca a pagina e verifica se existe
		function BuscaPagina(){
			$Sql = "Select * from c_paginas where nome = '".$this->Pagina."'";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			if($num_rows){
				return true;
			}else{
				return false;
			}
		}
		
		#Função que chama a pagina.php desejada.
		public function ChamaPhp($Nome){
			@require_once('lib/'.$Nome.'.php');
			return $Conteudo;
		}
	
		#Função que monta o html da pagina
		public function CarregaHtml($Nome){
			$filename = 'html/'.$Nome.".html";
			$handle = fopen($filename,"r");
			$Html = fread($handle,filesize($filename));
			fclose($handle);
			return $Html;
		}
		
		#Funcao que executa uma Sql e retorna.
		static function Execute($Sql){
			$result = mysql_query($Sql);
			return $result;
		}
		
		#Funcao que retorna o numero de linhas 
		static function Linha($result){
			$num_rows = mysql_num_rows($result);
			return $num_rows;
		}

		function MontaMsg($tipo,$msg){
			if($tipo == 'erro'){
				$flag = "<div class='alert alert-danger' role='alert'>
      			<strong>Erro!</strong> ".$msg." </div>";
			}elseif($tipo == 'ok'){
				$flag = "<div class='alert alert-success' role='alert'>
      			<strong>OK!</strong> ".$msg." </div>";
			}elseif($tipo == 'atencao'){
				$flag = "<div class='alert alert-warning' role='alert'>
      			<strong>Aviso!</strong> ".$msg." </div>";
			}
			return $flag;
		}
		
		#Funcao que carrega as páginas
		function CarregaPaginas(){
			$urlDesenvolve = 'wmotorsdobrasil';
			$primeiraBol = true;
			$uri = $_SERVER["REQUEST_URI"];
			$exUrls = explode('/',$uri);
			$SizeUrls = count($exUrls)-1;

			$p = 0;
			foreach( $exUrls as $chave => $valor ){
				if( $valor != '' && $valor != $urlDesenvolve ){
					$valorUri = $valor;
					$valorUri = strip_tags($valorUri);
					$valorUri = trim($valorUri);
					$valorUri = addslashes($valorUri);
					
					if( $primeiraBol ){
						$this->Pagina = $valorUri;
						$primeiraBol = false;
					}else{
						$this->PaginaAux[$p] = $valorUri;
						$p++;
					}
				}
			}
		}

		function MontaSelectMarcas($marca){
			$marcas = '<select name="marca" style="width:130px;">';
			$marcas .= '<option value="0">Marca</option>';
			$Sql = "Select idmarca , marca from c_marcas";
			$result = $this->Execute($Sql);
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
			$categorias = '<select name="categoria" style="width:120px;">';
			$categorias .= '<option value="0">Tipo</option>';
			$Sql = "Select idcategoria , categoria from fixo_categorias";
			$result = $this->Execute($Sql);
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

		function MontaSelectModelos(){
			$modelos = '<select name="modelo" style="width:120px;">';
			$modelos .= '<option value="0">Nome</option>';
			$Sql = "Select modelo from c_veiculos";
			$result = $this->Execute($Sql);
			while($aux = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$modelos .= '<option value="'.$aux['modelo'].'" '.$selected.'>'.$aux['modelo'].'</option>';
			}
			$modelos .= '</select>';
			return $modelos;	
		}
	}
?>