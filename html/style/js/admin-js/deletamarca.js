function deletamarca(id){
    var url = 'http://localhost/wmotorsdobrasil/lib/ajax/deletamarca.php';
    if (confirm("Deletar?") == true) { 
        $.post(url,
            {id: id},
                function(retorno){
                alert("Marca Deletada com Sucesso.")
            }
        );
    }
}
