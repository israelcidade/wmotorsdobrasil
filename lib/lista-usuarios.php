<?php
	#Include nas funcoes do folder
	include('functions/banco-usuario.php');

	#Instancia objeto que vai tratar o banco de dados dessa pagina
	$banco = new bancousuario();

	if($banco->VerificaSessao()){

		if($this->PaginaAux[0] == 'status'){
			$mgs = $banco->MudaStatus($this->PaginaAux[1],$this->PaginaAux[2]);
			$banco->RedirecionaPara('lista-usuarios');
		}

		#Carrega o html de Auxilio
		$Auxilio = $banco->CarregaHtml('itens/lista-usuarios-itens');

		#Chama funcao Lista Manual passando o Auxilio
		$Usuarios = $banco->ListaUsuarios($Auxilio);

		#Imprime Valores
		$Conteudo = $banco->CarregaHtml('lista-usuarios');
		$Conteudo = str_replace('<%USUARIOS%>',$Usuarios,$Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>