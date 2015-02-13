<?php
	class bancoconta extends banco{
		
		
		function BuscaInfoUsuario(){
			$Sql = "Select * from c_usuarios where cpf = '".$_SESSION['cpf']."' ";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			return $rs;
		}
		
		function AtualizarEndereco($end){
			$Sql = "Update c_usuarios set 
					cep = '".$end['cep']."', 
					endereco = '".$end['endereco']."',
					bairro = '".$end['bairro']."',
					cidade = '".$end['cidade']."',
					estado = '".$end['estado']."'
					where cpf = '".$_SESSION['cpf']."' " ;
			$result = parent::Execute($Sql);
			return true;
		}
		
	}
?>