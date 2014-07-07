<?php
	class bancocadastro extends banco{
		#Funcao que lista os Folders

		function BuscaCep($cep){
			$resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
			if(!$resultado){  
        		$resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";  
    		}  
    		parse_str($resultado, $retorno);   
    		return $retorno;
		}

		function CadastraUsuario($usuario){
			$Sql = "Insert into c_usuarios (nome,senha,nascimento,rg,cpf,cep,endereco,bairro,cidade,estado) VALUES ('".$usuario['nome']."','".$usuario['senha']."','".$usuario['nascimento']."','".$usuario['rg']."','".$usuario['cpf']."','".$usuario['cep']."','".$usuario['endereco']."','".$usuario['bairro']."','".$usuario['cidade']."','".$usuario['estado']."') ";
			
			if($this->BuscaUsuarioPorCpf($usuario['cpf'])){
				return MSG_ERRO_CPF_EXISTENTE;
			}elseif($usuario['senha'] != $usuario['confsenha']){
				return MSG_ERRO_SENHA_DIFERENTE;
			}elseif(!parent::Execute($Sql)){
				return MSG_ERRO_BANCO;
			}else{
				return 'ok';	
			}
		}

		function BuscaUsuarioPorCpf($cpf){
			$Sql = "Select * from c_usuarios where cpf = '".$cpf."' ";
			$result = parent::Execute($Sql);
			$num_rows = parent::Linha($result);
			return $num_rows;
		}
	}
?>