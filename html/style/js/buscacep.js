function buscacep() {
	$("input[name=bairro]").val('teste');
	if($.trim($("input[name=cep]").val()) != ""){
		$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("input[name=cep]").val(), function(){
		if(resultadoCEP["resultado"]){
			$("input[name=endereco]").val(unescape(resultadoCEP["tipo_logradouro"])+": "+unescape(resultadoCEP["logradouro"]));
			$("input[name=bairro]").val(unescape(resultadoCEP["bairro"]));
			$("input[name=cidade]").val(unescape(resultadoCEP["cidade"]));
			$("input[name=estado]").val(unescape(resultadoCEP["uf"]));
		}else{
			alert("Endereço não encontrado");
			}
		});				
	}			
}
