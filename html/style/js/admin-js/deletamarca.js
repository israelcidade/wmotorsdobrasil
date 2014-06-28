function deletamarca(){
    alert('teste1');
    
    $.post('http://localhost/wmotorsdobrasil/lib/ajax/deletamarca.php',
        {},
            function(retorno){
            alert('teste');
        }
    );
}
