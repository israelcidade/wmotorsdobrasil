$("#busca-marca").change(function() {
	var marca = $("#busca-marca option:selected").val();
	
	$.post("lib/ajax/busca-veiculos-por-idmarca.php",
	            {marca: marca},
	            function(retorno){
	            	
	              $("#busca-veiculo").empty().append(retorno);
	            }
	            
        	);
  	
});