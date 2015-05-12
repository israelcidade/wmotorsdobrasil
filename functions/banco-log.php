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
			$Sql = "Select * 
					from c_usuarios U
					INNER JOIN c_pagamento P
					ON U.cpf = P.pagamento_cpf
					Where U.cpf = '".$cpf."'";

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
					$Linha = str_replace('<%NOME%>',$rs['nome'],$Linha);
						
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
				$data_ultimo_pagamento = parent::BuscaDataValidadePagamento($arr['cpf_pagamento']);
				
				$hoje = date('Y-m-d');
				if(strtotime($hoje) > strtotime($data_ultimo_pagamento)){
					$Select_pagamento = "Update c_usuarios set pagamento = 0 where cpf = '".$arr['cpf_pagamento']."'";
					$result_pagamento = $this->Execute($Select_pagamento);
				}else{
					$Select_pagamento = "Update c_usuarios set pagamento = 1 where cpf = '".$arr['cpf_pagamento']."'";
					$result_pagamento = $this->Execute($Select_pagamento);
				}
				
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
			$data_ultimo_pagamento = parent::BuscaDataValidadePagamento($arr['cpf_pagamento']);
				
				$hoje = date('Y-m-d');
				if(strtotime($hoje) > strtotime($data_ultimo_pagamento)){
					$Select_pagamento = "Update c_usuarios set pagamento = 0 where cpf = '".$arr['cpf_pagamento']."'";
					$result_pagamento = $this->Execute($Select_pagamento);
				}else{
					$Select_pagamento = "Update c_usuarios set pagamento = 1 where cpf = '".$arr['cpf_pagamento']."'";
					$result_pagamento = $this->Execute($Select_pagamento);
				}
				
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
		
		function DeletaPagamento($id){
			$Sql_select = "Select pagamento_cpf from c_pagamento where pagamento_id = '".$id."'";
			$result_select = $this->Execute($Sql_select);
			$rs = mysql_fetch_array($result_select , MYSQL_ASSOC);
			if($result_select){
				$Sql = "Delete from c_pagamento where pagamento_id = '".$id."' ";
				$result = $this->Execute($Sql);
				
				//Verifica ultimo pagamento
				$data_ultimo_pagamento = parent::BuscaDataValidadePagamento($rs['pagamento_cpf']);
				
				if($data_ultimo_pagamento == NULL){
					$Select_pagamento = "Update c_usuarios set pagamento = 0 where cpf = '".$rs['pagamento_cpf']."'";
					$result_pagamento = $this->Execute($Select_pagamento);
				}else{
					$data_ultimo_pagamento = parent::BuscaDataValidadePagamento($arr['cpf_pagamento']);
					$hoje = date('Y-m-d');
					if(strtotime($hoje) > strtotime($data_ultimo_pagamento)){
						$Select_pagamento = "Update c_usuarios set pagamento = 0 where cpf = '".$arr['cpf_pagamento']."'";
						$result_pagamento = $this->Execute($Select_pagamento);
					}else{
						$Select_pagamento = "Update c_usuarios set pagamento = 1 where cpf = '".$arr['cpf_pagamento']."'";
						$result_pagamento = $this->Execute($Select_pagamento);
					
					}
				}
				
				return $rs['pagamento_cpf'];
			}
		}
		
	}
?>