<?php
	class bancoinicio extends banco{
		
		function BuscaUsuario($cpf,$senha){
			$Sql = "Select * from c_usuarios where cpf = '".$cpf."' AND senha = '".$senha."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}

	}
?>