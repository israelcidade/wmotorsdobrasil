$("#busca-marca").change(function() {
	var aux = location.host;
	
	if(aux === "localhost"){
		var url = 'http://localhost/wmotorsdobrasil/lib/ajax/busca-veiculos-por-idmarca.php';
	}else{
		var url = 'http://www.wmotorsdobrasil.com.br/lib/ajax/busca-veiculos-por-idmarca.php';
	}
	
	var marca = $("#busca-marca option:selected").val();
	
	$.post(url,
	            {marca: marca},
	            function(retorno){
	            	
	              $("#busca-veiculo").empty().append(retorno);
	            }
	            
        	);
  	
});

$("#busca-categoria").change(function() {
	var aux = location.host;
	
	if(aux === "localhost"){
		var url = 'http://localhost/wmotorsdobrasil/lib/ajax/busca-marcas-por-idcategoria.php';
	}else{
		var url = 'http://www.wmotorsdobrasil.com.br/lib/ajax/busca-marcas-por-idcategoria.php';
	}
	
	var categoria = $("#busca-categoria option:selected").val();
	
	$.post(url,
	            {categoria: categoria},
	            function(retorno){
	            	
	              $("#busca-marca").empty().append(retorno);
	            }
	            
        	);
  	
});