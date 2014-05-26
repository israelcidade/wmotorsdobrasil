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
					$Linha = str_replace('<%NOME%>',$rs['user'],$Linha);
					$Usuarios .= $Linha;
				}
			}else{
				$mensagem = $Banco_Vazio;
			}
			return $Usuarios;
		}

	}
?>