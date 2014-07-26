<?php
	#include das funcoes da tela inico
	include('functions/banco-marca.php');

	#Instancia o objeto
	$banco = new bancomarca();

	#Declara Variaveis
	$botao = 'Salvar';
	$botaodeletar = '';
	$marca = '';
	$img = '';

	if($banco->VerificaSessao()){

		#Trabalha com Editar
		if($this->PaginaAux[0] == 'editar'){
			$idmarca = $this->PaginaAux[1];
			$botao = 'Atualizar';	
			$result = $banco->BuscaMarca($idmarca);
			$num_rows = $banco->Linha($result);

			if($num_rows){
				$rs = mysql_fetch_array($result , MYSQL_ASSOC);
				$marca = $rs['marca'];
				$foto = $rs['foto'];
				$img = '<img src="'.UrlPadrao.$foto.'" alt="'.$marca.'">';
			}
		}

		#Trabalha com Post
		if( isset($_POST["acao"]) && $_POST["acao"] != '' ){
			$marca = strip_tags(trim(addslashes($_POST["marca"])));
			$foto = $_FILES["foto"];
			
			if($banco->BuscaMarcaPorNome($marca)){
				$msg = $banco->MontaMsg('erro',MSG_ERRO_MARCA_CADASTRADA);
			}else{
				if($botao == 'Atualizar'){
					if(empty($foto['name'])){
						$SqlBanco = "Update c_marcas SET marca = '".$marca."' where idmarca = '".$idmarca."' ";
					}else{
						if($banco->DeletaFotoAntiga($idmarca)){
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
							$caminho_foto = "arq/marcas/".$idmarca.'.'.$ext[1];
							move_uploaded_file($foto["tmp_name"], $caminho_foto);
							$SqlBanco = "Update c_marcas SET marca = '".$marca."', foto = '".$caminho_foto."' where idmarca = '".$idmarca."' ";
						}
					}
				}else{
					$ultimoid = $banco->BuscaMaxId();
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
					$caminho_foto = "arq/marcas/".$ultimoid.'.'.$ext[1];
					move_uploaded_file($foto["tmp_name"], $caminho_foto);
					$SqlBanco = "Insert Into c_marcas (marca, foto) VALUES ('".$marca."','".$caminho_foto."')";
				}

				$banco->Execute($SqlBanco);
				$banco->RedirecionaPara('lista-marcas');
			}
		}

		#Imprimi valores
		$Conteudo = $banco->CarregaHtml('marca');
		$Conteudo = str_replace('<%BOTAO%>',$botao,$Conteudo);
		$Conteudo = str_replace('<%BOTAODELETAR%>',$botaodeletar,$Conteudo);
		$Conteudo = str_replace('<%MARCA%>',$marca,$Conteudo);
		$Conteudo = str_replace('<%IMG%>',$img,$Conteudo);
		$Conteudo = str_replace('<%MSG%>',$msg,$Conteudo);
	}else{
		$banco->RedirecionaPara('inicio/acesso');
	}
?>