<?php
	class bancosobre extends banco{
		#Funcao que lista os Folders
		function SalvarSobre($sobre){
			$Sql = "Update c_sobre set sobre = '".$sobre."' where idsobre = 0 " ;
			$result = parent::Execute($Sql);
			return $result;
		}
		
		function SelectSobre(){
			$Sql = "Select sobre from c_sobre where idsobre = 0";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			$sobre = $rs['sobre'];
			return $sobre;
		}
	}
?>