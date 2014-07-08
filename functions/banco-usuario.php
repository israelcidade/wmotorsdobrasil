<?php
	class bancousuario extends banco{

		#Funcao que lista os Folders
		function ListaUsuarios($Auxilio){
			$Banco_Vazio = "Banco esta Vazio";
			#Query Busca Folders
			$Sql = "Select * from c_usuarios";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);

			#Monta no Html a Listagem
			if ($num_rows){
				while( $rs = mysql_fetch_array($result , MYSQL_ASSOC) )
				{
					$Linha = $Auxilio;
					$Linha = str_replace('<%ID%>',$rs['idusuario'],$Linha);
					$Linha = str_replace('<%NOME%>',$rs['nome'],$Linha);
					$Linha = str_replace('<%CPF%>',$rs['cpf'],$Linha);
					if($rs['status'] == '0'){
						$Linha = str_replace('<%STATUS%>','inativo',$Linha);
						$Linha = str_replace('<%BOTAO%>','btn-edit',$Linha);
						$Linha = str_replace('<%BOTAOVALUE%>','Ativar',$Linha);
						
					}else{
						$Linha = str_replace('<%STATUS%>','ativo',$Linha);
						$Linha = str_replace('<%BOTAO%>','btn-delete',$Linha);
						$Linha = str_replace('<%BOTAOVALUE%>','Desativar',$Linha);
					}
					
					$Usuarios .= $Linha;
				}
			}else{
				$mensagem = $Banco_Vazio;
			}
			return $Usuarios;
		}

		function MudaStatus($status,$cpf){
			if($status == 'ativo'){
				$flag = '0';
			}else{
				$flag = '1';
			}
			$Sql = "Update c_usuarios set status = '".$flag."' where cpf='".$cpf."' ";
			if($result = parent::Execute($Sql)){
				return true;
			}else{
				return false;
			}
			
		}
	}
?>