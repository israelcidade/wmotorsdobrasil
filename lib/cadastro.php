<?php
	#include das funcoes da tela inico
	include('functions/banco-cadastro.php');

	#Instancia o objeto
	$banco = new bancocadastro();

	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'cadastrar'){
		$usuario['nome'] = strip_tags(trim(addslashes($_POST["nome"])));
		$usuario['nacimento'] = strip_tags(trim(addslashes($_POST["nascimento"])));
		$usuario['rg'] = strip_tags(trim(addslashes($_POST["rg"])));
		$usuario['cpf'] = strip_tags(trim(addslashes($_POST["cpf"])));
		$usuario['cep'] = strip_tags(trim(addslashes($_POST["cep"])));
		$usuario['endereco'] = strip_tags(trim(addslashes($_POST["endereco"])));
		$usuario['estado'] = strip_tags(trim(addslashes($_POST["estado"])));
		$usuario['cidade'] = strip_tags(trim(addslashes($_POST["cidade"])));
		$usuario['senha'] = strip_tags(trim(addslashes($_POST["senha"])));
		$usuario['confsenha'] = strip_tags(trim(addslashes($_POST["confsenha"])));

		$msg = $banco->CadastraUsuario($usuario);
		if($msg == 'ok'){
			$banco->RedirecinaPara('inicio');
		}

	}

	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'buscar-cep'){
		$cep = strip_tags(trim(addslashes($_POST["cep"])));
		$arr = $banco->BuscaCep($cep);
	}
	
	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('cadastro');
	$Conteudo = str_replace('<%CEP%>', $cep, $Conteudo);
	$Conteudo = str_replace('<%ENDERECO%>',$arr['tipo_logradouro'].' '.$arr['logradouro'].'-'.$arr['bairro'], $Conteudo);
	$Conteudo = str_replace('<%ESTADO%>', $arr['uf'], $Conteudo);
	$Conteudo = str_replace('<%CIDADE%>', $arr['cidade'], $Conteudo);
?>