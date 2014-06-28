function deletamarca(id){
    var url = 'http://localhost/wmotorsdobrasil/lib/ajax/deletamarca.php';
    if (confirm("Deletar?") == true) { 
        $.post(url,
            {id: id},
                function(retorno){
                if(retorno == true){
                    alert("Marca Deletada com Sucesso.");
                    window.location.reload();
                }else{
                    alert("Falha ao excluir");
                }
            }
        );
    }
}
