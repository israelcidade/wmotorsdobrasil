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
					
					$timestamp = strtotime($rs['data']);
					$data_formatada = date('d/m/Y h:i', $timestamp);
					
					$Linha = str_replace('<%DATA%>',$data_formatada,$Linha);
					$Logs .= $Linha;
				}
			}else{
				return $msg = $this->MontaMsg('atencao',ERRO_ZERO_LOGS);
			}

			return $Logs;
		
		}
		
		function ListaLogsPagamento($cpf){
			$Sql = "Select * from c_pagamento where pagamento_cpf = '".$cpf."'";

			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
		
			$Auxilio = parent::CarregaHtml('itens/lista-pagamento-itens');
		
			#Monta no Html a Listagem
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$Linha = $Auxilio;
					$Linha = str_replace('<%CPF%>',$cpf,$Linha);
					$Linha = str_replace('<%PAGAMENTOTIPO%>',$rs['pagamento_tipo'],$Linha);
						
					$timestamp_pagamento_data = strtotime($rs['pagamento_data']);
					$pagamento_data = date('d/m/Y', $timestamp_pagamento_data);
					$Linha = str_replace('<%PAGAMENTODATA%>',$pagamento_data,$Linha);
					
					$timestamp_pagamento_validade = strtotime($rs['pagamento_validade']);
					$pagamento_validade = date('d/m/Y', $timestamp_pagamento_validade);
					$Linha = str_replace('<%PAGAMENTOVALIDADE%>',$pagamento_validade,$Linha);
					
					$Linha = str_replace('<%PAGAMENTOID%>',$rs['pagamento_id'],$Linha);
					$Linha = str_replace('<%URLPADRAO%>',UrlPadrao,$Linha);
					
					$Logs .= $Linha;
				}
			}else{
				return $msg = $this->MontaMsg('atencao',ERRO_ZERO_LOGS);
			}
		
			return $Logs;
		
		}
		
		function SalvaPagamento($arr){
			$Sql = "Insert into c_pagamento 
					(pagamento_tipo,pagamento_data,pagamento_validade,pagamento_cpf) 
					VALUES 
					('".$arr['plano_pagamento']."','".$arr['data_pagamento']."','".$arr['validade_pagamento']."','".$arr['cpf_pagamento']."')
					";
			
			if(parent::Execute($Sql)){
				return true;
			}else{
				return false;
			}
		
		}
		
		function AtualizaPagamento($arr){
			
			$Sql = "
					Update c_pagamento set 
					pagamento_tipo 		= '".$arr['plano_pagamento']."',
					pagamento_data 		= '".$arr['data_pagamento']."',
					pagamento_validade 	= '".$arr['validade_pagamento']."',
					pagamento_cpf 		= '".$arr['cpf_pagamento']."'
					where pagamento_id 	= '".$arr['pagamento_id']."'
					";
				
			if(parent::Execute($Sql)){
				return true;
			}else{
				return false;
			}
		
		}
		
		function BuscaPagamentoPorId($id){
			$Sql = "Select * from c_pagamento where pagamento_id = '".$id."' ";
			$result = parent::Execute($Sql);
			$rs = mysql_fetch_array($result , MYSQL_ASSOC);
			return $rs;
		}
		
	}
?>