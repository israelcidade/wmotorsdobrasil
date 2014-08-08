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
		autoPlay:true,
		autoPlay:2000
	});

	// GALERIA DE IMAGENS

	$('#galeria-favoritos').owlCarousel({
		items:1,
		singleItem:true,
		autoPlay:true
	});

	$('.galeria').fancybox();

	// TEXTOS DAS IMAGENS

	$('.conteudo-carro:first').show();

	$('#small-pics li a').click(function(e){
		e.preventDefault();

		var id = $(this).attr('data-id');
		var conteudo = '#desc'+id;

		$('.conteudo-carro').hide();
		$(conteudo).show();

	});

});