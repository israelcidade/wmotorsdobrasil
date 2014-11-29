$(document).ready(function(){

	var banners = $('#banner ul');

	banners.owlCarousel({
		items:1,
		singleItem:true,
		autoPlay:6000
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
		autoPlay:3000
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


	// Máscaras de campo
	$('#i-nascimento').mask('99/99/9999');
	$('#i-rg').mask('9999999999');
	$('#i-cpf').mask('999.999.999-99');
	$('#l-cpf').mask('999.999.999-99');
	$('#i-cep').mask('99999-999');

});