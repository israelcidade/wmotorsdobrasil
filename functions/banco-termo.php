<?php
	class bancotermo extends banco{
		#Funcao que lista os Folders
		function SalvarTermo($termo){
			$Sql = "Update c_termo set termo = '".$termo."' where idtermo = 0 " ;
			$result = parent::Execute($Sql);
			return $result;
		}
		
		function SelectTermo(){
			$Sql = "Select termo from c_termo where idtermo = 0";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			$termo = $rs['termo'];
			return $termo;
		}
	}
?>