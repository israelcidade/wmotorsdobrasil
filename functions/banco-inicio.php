<?php
	class bancoinicio extends banco{
		
		function BuscaUsuario($usuario,$senha){
			$Sql = "Select * from c_usuarios where user = '".$usuario."' AND senha = '".$senha."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}

	}
?>