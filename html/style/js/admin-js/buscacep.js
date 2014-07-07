function buscacep(){
    var cep = $("input[name=cep]").val();
    var url = 'http://localhost/wmotorsdobrasil/lib/ajax/buscacep.php';
    $.post(url,
        {id: cep},
        function(retorno){
        	alert(retorno);
        }
    );
}
