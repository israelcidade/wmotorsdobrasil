<?php
	class bancolog extends banco{
		#Funcao que lista os Folders

		function ListaLogs($cpf){
			$Sql = "Select * from c_log_acesso where cpf = '".$cpf."'";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);

			$Auxilio = parent::CarregaHtml('itens/lista-logs-itens');

			#Monta no Html a Listagem
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$Linha = $Auxilio;
					$Linha = str_replace('<%CPF%>',$cpf,$Linha);
					$Linha = str_replace('<%IP%>',$rs['ip'],$Linha);
					$Linha = str_replace('<%DATA%>',$rs['data'],$Linha);
					$Logs .= $Linha;
				}
			}else{
				return $msg = $this->MontaMsg('atencao',ERRO_ZERO_LOGS);
			}

			return $Logs;
		
		}
		
	}
?>