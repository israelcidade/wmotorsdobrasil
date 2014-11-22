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
			
			$this->GravaLog($cpf);
		}

		function IniciaSessaoAdmin($user){
			session_start('login');
			$_SESSION['cpf'] = $user;
			$_SESSION['admin'] = '1';
			
			$this->GravaLog($user);
		}

		#fecha sessao
		function FechaSessao(){
			session_start('login');
			$_SESSION = array();
			session_destroy();
		}

		function VerificaSessao(){
			session_start('login');
			if(isset($_SESSION['cpf']) ){
				$Sql = "Select status from c_usuarios where cpf = '".$_SESSION['cpf']."'";
				$result = $this->Execute($Sql);
				$num_rows = $this->Linha($result);
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				if($rs['status'] == '1'){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		function VerificaSessaoAdmin(){
			session_start('login');
			if(isset($_SESSION['admin']) ){
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
			if( $this->Pagina == 'veiculo' || 
				$this->Pagina == 'lista-veiculos' || 
				$this->Pagina == 'lista-marcas' || 
				$this->Pagina == 'marca' ||
				$this->Pagina == 'log-acesso' ||
				$this->Pagina == 'lista-usuarios'){

				$SaidaHtml = $this->CarregaHtml('modelo-admin');
			
			}elseif($this->Pagina == 'admin'){
				$SaidaHtml = $this->CarregaHtml('modelo-login-admin');
			}else{
				$SaidaHtml = $this->CarregaHtml('modelo');	
			}

			$Menu = $this->MontaMenu();
			$Busca = $this->MontaBusca();

			if($this->VerificaSessao()){
				$Login = $this->MontaLoginLogado();	
			}else{
				$Login = $this->MontaLogin();
			}
			

			$SaidaHtml = str_replace('<%CONTEUDO%>',$Conteudo,$SaidaHtml);
			$SaidaHtml = str_replace('<%URLPADRAO%>',UrlPadrao,$SaidaHtml);
			$SaidaHtml = str_replace('<%MENU%>',$Menu,$SaidaHtml);
			$SaidaHtml = str_replace('<%BUSCA%>',$Busca,$SaidaHtml);
			$SaidaHtml = str_replace('<%LOGIN%>',$Login,$SaidaHtml);

			echo $SaidaHtml;
		}

		function MontaLogin(){
			$Login = $this->CarregaHtml('itens/login');
			$Login = str_replace('<%URLPADRAO%>',UrlPadrao,$Login);
			return $Login;
		}

		function MontaLoginLogado(){
			$Sql = "Select * from c_usuarios where cpf = '".$_SESSION['cpf']."'";
			$result = $this->Execute($Sql);
			$num_rows = $this->Linha($result);
			$rs = mysql_fetch_array($result, MYSQL_ASSOC);
			$Auxilio = $this->CarregaHtml('itens/login-logado');
			$Auxilio = str_replace('<%NOME%>',$rs['nome'],$Auxilio);
			$Auxilio = str_replace('<%URLPADRAO%>',UrlPadrao,$Auxilio);
			$Auxilio = str_replace('<%CPF%>',$rs['cpf'],$Auxilio);
			return $Auxilio;
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
		
		#Fun��o que chama a pagina.php desejada.
		public function ChamaPhp($Nome){
			@require_once('lib/'.$Nome.'.php');
			return $Conteudo;
		}
	
		#Fun��o que monta o html da pagina
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
				$flag = "<div class='alert alert-danger alert-danger-estilo' role='alert'>
      			<strong>Erro!</strong> ".$msg."</div>";
			}elseif($tipo == 'ok'){
				$flag = "<div class='alert alert-success' role='alert'>
      			<strong>OK!</strong> ".$msg." </div>";
			}elseif($tipo == 'atencao'){
				$flag = "<div class='alert alert-warning' role='alert'>
      			<strong>Aviso!</strong> ".$msg." </div>";
			}
			return $flag;
		}
		
		#Funcao que carrega as p�ginas
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
			$marca = '';
			$marcas = '<select id="busca-marca" name="marca" style="width:130px;">';
			$marcas .= '<option value="0">Marca</option>';
			/*$Sql = "Select idmarca , marca from c_marcas";
			$result = $this->Execute($Sql);
			while($aux = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$selected = '';
				if($marca == $aux['idmarca']){
					$selected = 'selected';
				}
				$marcas .= '<option value="'.$aux['idmarca'].'" '.$selected.'>'.$aux['marca'].'</option>';
			}*/
			$marcas .= '</select>';
			return $marcas;	
		}

		function MontaSelectCategorias($categoria){
			$categorias = '<select id="busca-categoria" name="categoria" style="width:120px;">';
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
			$modelos = '<select id="busca-veiculo" name="modelo" style="width:120px;">';
			$modelos .= '<option value="0">Nome</option>';
			/*$Sql = "Select modelo from c_veiculos";
			$result = $this->Execute($Sql);
			while($aux = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$modelos .= '<option value="'.$aux['modelo'].'" '.$selected.'>'.$aux['modelo'].'</option>';
			}*/
			$modelos .= '</select>';
			return $modelos;	
		}

		function MarcaDagua($foto,$idveiculo,$ext){
			$caminho_foto = "arq/veiculos/".$idveiculo.'/';
			include_once('app/easyphpthumbnail/PHP5/easyphpthumbnail.class.php');
			$thumb = new easyphpthumbnail;
			$exifdata = $thumb -> read_exif($foto);
			$thumb -> Chmodlevel = '0777';
			$thumb -> Thumblocation = $caminho_foto;
			$thumb -> Thumbprefix = '';
			$thumb -> Thumbfilename = (md5(uniqid(time())).'.'.$ext[1]);
			$thumb -> Thumbsize = 0;
			$thumb -> Clipcorner = array(0);
			$thumb -> Watermarkpng = 'html/style/images/marca.png';
			$thumb -> Watermarkposition = '50% 50%';
			$thumb -> Watermarktransparency = 35;  
			$thumb -> Createthumb($foto,'file');
			$thumb -> insert_exif($caminho_foto.$thumb->Thumbfilename, $exifdata);

			return $caminho_foto.$thumb->Thumbfilename;
		}

		function EnviaEmailCadastro($email){
            #Carrega classe MAILER
			include_once("../../app/PHPMailer/class.phpmailer.php");
			include("../../app/PHPMailer/class.smtp.php");

			$mail = new PHPMailer();
			// Charset para evitar erros de caracteres
			$mail->Charset = 'UTF-8';
			// Dados de quem est� enviando o email
			$mail->From = 'contato@wmotorsdobrasil.com';
			$mail->FromName = 'wmotorsdobrasil';

			// Setando o conteudo
			$mail->IsHTML(true);
			$mail->Subject = 'WmotorsDoBrasil -> Bem Vindo';
			$mail->Body = utf8_decode(
				'Bem Vindo ao Wmotors do Brasil!<br>
				Realize seu pagamento e come�e a utilizar nosso site para suas pesquisas!'
				);
            
            // Validando a autentica��o
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host     = "ssl://smtp.gmail.com";
			$mail->Port     = 465;
			$mail->Username = EMAIL_USER;
			$mail->Password = EMAIL_PASS;

			// Setando o endere�o de recebimento
			$mail->AddAddress($email);
            
			// Enviando o e-mail para o usu�rio
            if($mail->Send()){
            	return true;
            }else{
            	return false;
            }
        }

        function BuscaCpf($cpf){
        	$Sql = "Select * from c_usuarios where cpf = '".$cpf."'";
        	$result = $this->Execute($Sql);
        	$num_rows = $this->Linha($result);
        	if($num_rows){
        		return true;
        	}else{
        		return false;
        	}
        }

        function validaCPF($cpf)
		{	// Verifiva se o n�mero digitado cont�m todos os digitos
		    $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
			
			// Verifica se nenhuma das sequ�ncias abaixo foi digitada, caso seja, retorna falso
		    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
			{
			return false;
		    }
			else
			{   // Calcula os n�meros para verificar se o CPF � verdadeiro
		        for ($t = 9; $t < 11; $t++) {
		            for ($d = 0, $c = 0; $c < $t; $c++) {
		                $d += $cpf{$c} * (($t + 1) - $c);
		            }
		 
		            $d = ((10 * $d) % 11) % 10;
		 
		            if ($cpf{$c} != $d) {
		                return false;
		            }
		        }
		 
		     return true;
    		}
		}
		
		function GravaLog($cpf){
			$ip = $_SERVER["REMOTE_ADDR"];
			$data = date('Y-m-d H:i:s');
			
			$Sql = "Insert into c_log_acesso (cpf, ip, data ) VALUES ('".$cpf."','".$ip."','".$data."')";
			$this->Execute($Sql);
		}
	}
?>