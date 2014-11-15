$("#busca-marca").change(function() {
	var teste = location.host;
	
	if(teste === "localhost:8888"){
		var url = 'http://localhost:8888/wmotorsdobrasil/lib/ajax/busca-marcas-por-idcategoria.php';
	}else{
		var url = 'http://www.wmotorsdobrasil.com.br/lib/ajax/busca-marcas-por-idcategoria.php';
	}
	
	var marca = $("#busca-marca option:selected").val();
	
	$.post("lib/ajax/busca-veiculos-por-idmarca.php",
	            {marca: marca},
	            function(retorno){
	            	
	              $("#busca-veiculo").empty().append(retorno);
	            }
	            
        	);
  	
});

$("#busca-categoria").change(function() {
	var teste = location.host;
	
	if(teste === "localhost:8888"){
		var url = 'http://localhost:8888/wmotorsdobrasil/lib/ajax/busca-marcas-por-idcategoria.php';
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