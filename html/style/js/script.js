// *** INFORMAÇÕES DE CONTA

$('#tabs li a').click(function(e){
	e.preventDefault();

	var id = $(this).attr('data-id');

	$('#tabs li a').removeClass('current');
	$(this).addClass('current');

	$('.sections section').hide();
	$('#'+id).fadeIn();

});

$(document).ready(function(){
	$('#tabs li:first a').click();
});

// *** INFORMAÇÕES DE CONTA

var banners = $('#banner ul');
banners.owlCarousel({
	items:1,
	singleItem:true,
	autoPlay:6000
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
	autoPlay:2000,
	items:1,
	singleItem:true
});

$('.galeria').fancybox();

// LOGIN

$('#login').click(function(e){
	e.preventDefault();

	$('#login').toggleClass('active');
	$('#login-box').stop(true, true).slideToggle();
	
});

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
$('#i-cpf').mask('999.999.999-99');
$('#i-cep').mask('99999-999');

$('#l-cpf').mask('999.999.999-99');


// LISTA DE PARCEIROS
$('#parceiros li').hover(function(){
	$(this).not('.nopic').find('.hover').stop(true,true).fadeToggle();
});

// ESCOLHA DO PLANO

//Assinatura: BECFFCAB4E4E36E994AD3F915D884F0C
//Compra Anual: 7DAEE227AEAE84BFF48B2F949F2E3F75

$('#plano-mensal').click(function(e){
	e.preventDefault();

	$(this).removeClass('faded');
	$('#plano').val('mensal');
	$('#plano-anual').addClass('faded');
	$('#codigo-assinatura').val('BECFFCAB4E4E36E994AD3F915D884F0C');

});

$('#plano-anual').click(function(e){
	e.preventDefault();

	$(this).removeClass('faded');
	$('#plano').val('anual');
	$('#plano-mensal').addClass('faded');
	$('#codigo-assinatura').val('7DAEE227AEAE84BFF48B2F949F2E3F75');

});

// SCRIPT DO MODAL DE TERMOS DE SERVIÇO
function Termo(){
	$('#overlay').fadeIn();

	$('#fechar').click(function(e){
		$('#overlay').fadeOut();
	});
}

// ESCOLHA DO TIPO DE PESSOA
$('#pessoa').change(function(){

	var pessoa = $(this).val();
	console.log(pessoa)

	if(pessoa == 'juridica'){
		$('#i-cpf').attr('placeholder','CNPJ').mask('99.999.999/9999-99');
	} else {
		$('#i-cpf').attr('placeholder','CPF').mask('999.999.999-99');
	}

});

// ESCOLHA DO TIPO DE PESSOA

$('input[type=radio][name=tipo-login]').change(function() {
        if (this.value == 'tipo-login-cpf') {
        	$('#login-cpf').mask('999.999.999-99');
        }
        else if (this.value == 'tipo-login-cnpj') {
        	$('#login-cpf').mask('99.999.999/9999-99');
        }
    });
