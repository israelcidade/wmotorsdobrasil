<?php
	#include das funcoes da tela inico
	include('functions/banco-cadastro.php');

	#Instancia o objeto
	$banco = new bancocadastro();

	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'cadastrar'){
		$usuario['nome'] = strip_tags(trim(addslashes($_POST["nome"])));
		$usuario['nascimento'] = strip_tags(trim(addslashes($_POST["nascimento"])));
		$usuario['email'] = strip_tags(trim(addslashes($_POST["email"])));
		$usuario['rg'] = strip_tags(trim(addslashes($_POST["rg"])));
		$usuario['cpf'] = strip_tags(trim(addslashes($_POST["cpf"])));
		$usuario['cep'] = strip_tags(trim(addslashes($_POST["cep"])));
		$usuario['endereco'] = strip_tags(trim(addslashes($_POST["endereco"])));
		$usuario['complemento'] = strip_tags(trim(addslashes($_POST["complemento"])));
		$usuario['bairro'] = strip_tags(trim(addslashes($_POST["bairro"])));
		$usuario['cidade'] = strip_tags(trim(addslashes($_POST["cidade"])));
		$usuario['estado'] = strip_tags(trim(addslashes($_POST["estado"])));
		$usuario['senha'] = md5(strip_tags(trim(addslashes($_POST["senha"]))));
		$usuario['confsenha'] = md5(strip_tags(trim(addslashes($_POST["confsenha"]))));

		$msg = $banco->CadastraUsuario($usuario);
		if($msg == 'ok'){
			$banco->RedirecionaPara('inicio');
		}

	}

	if( isset($_POST["acao"]) && $_POST["acao"] != '' && $_POST["acao"] == 'buscar-cep'){
		$cep = strip_tags(trim(addslashes($_POST["cep"])));
		$arr = $banco->BuscaCep($cep);
	}
	
	$termo = $banco->TermoDeUso();
	
	#Imprimi valores
	$Conteudo = $banco->CarregaHtml('cadastro');
	$Conteudo = str_replace('<%MSG%>', $msg, $Conteudo);
	$Conteudo = str_replace('<%TERMO%>', $termo, $Conteudo);
	$Conteudo = str_replace('<%CEP%>', $cep, $Conteudo);
	$Conteudo = str_replace('<%ENDERECO%>',$arr['tipo_logradouro'].' '.$arr['logradouro'], $Conteudo);
	$Conteudo = str_replace('<%BAIRRO%>', $arr['bairro'], $Conteudo);
	$Conteudo = str_replace('<%ESTADO%>', $arr['uf'], $Conteudo);
	$Conteudo = str_replace('<%CIDADE%>', $arr['cidade'], $Conteudo);
?>