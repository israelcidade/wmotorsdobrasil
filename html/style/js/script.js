$(document).ready(function(){

	var banners = $('#banner ul');

	banners.owlCarousel({
		items:1,
		singleItem:true,
		autoPlay:true
	});

	// LOGIN

	$('.login-wrapper').hover(function(){
		$('#login').toggleClass('active');
		$('#login-box').stop(true, true).slideToggle();
	});

	// MARCAS

	var marcas = $('#galeria-marcas');
	marcas.owlCarousel({
		items:1,
		singleItem:true,
		autoPlay:true
	});

	// GALERIA DE IMAGENS

	$('.galeria').fancybox();

});