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

		
		
	}
?>