$("#busca-marca").change(function() {
	var marca = $("#busca-marca option:selected").val();
	
	$.post("lib/ajax/busca-veiculos-por-idmarca.php",
	            {marca: marca},
	            function(retorno){
	            	
	              $("#busca-veiculo").empty().append(retorno);
	            }
	            
        	);
  	
});

$("#busca-categoria").change(function() {
	var categoria = $("#busca-categoria option:selected").val();
	
	$.post("lib/ajax/busca-marcas-por-idcategoria.php",
	            {categoria: categoria},
	            function(retorno){
	            	
	              $("#busca-marca").empty().append(retorno);
	            }
	            
        	);
  	
});