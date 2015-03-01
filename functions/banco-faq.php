<?php
	class bancofaq extends banco{
		#Funcao que lista os Folder
		function ExportarEmails(){
			$Sql = "Select email from c_usuarios";
			$result = $this->Execute($Sql);
			
			$fp = fopen('arq/emails/emails.txt' , "w+");
		
			while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
			{
				$escreve = fwrite($fp, $rs['email'].',');
			}
			
			fclose($fp);
			
			return true;
		}
		
		function Download(){
			$path = 'arq/emails/emails.txt';
			header("Content-Type: application/force-download");
			header("Content-type: application/octet-stream;");
			header("Content-Length: " . filesize( $path ) );
			header("Content-disposition: attachment; filename=emails.txt" );
			header("Pragma: no-cache");
			header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Expires: 0");
			readfile( $path );
			flush();
		}
	}
?>