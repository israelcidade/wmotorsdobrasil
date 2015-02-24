// GLOBAL FUNCTIONS

$.fn.centraliza = function() {
    var l = $(this).width();
    var a = $(this).height();
    
    var aVal = (a/2)-a+'px';
    var lVal = (l/2)-l+'px';
    
    $(this).css({
        'position':'fixed',
        'top':'50%',
        'left':'50%',
        'width':l,
        'height':a,
        'margin-left':lVal,
        'margin-top':aVal
    });  
};

$('.input-data').mask('99/99/9999');