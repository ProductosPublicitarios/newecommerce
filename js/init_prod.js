$(document).ready(function() {
	$("#map").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'width'			:	660, 
		'height'		:	440,
		'type'			:	'iframe'
	});
	
	$("a.iframe").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'width'			:	660, 
		'height'		:	440,
		'type'			:	'iframe'
	});
	$("a.iframex").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'width'			:	400, 
		'height'		:	540,
		'type'			:	'iframe'
	});
	
	$('.product-sub ul li a.lightbox').fancybox();
	
	$('#add_fav').click(addFav);
	$('#srch_send').click(validBuscar);
	$('#envio_cotizar').click(validContact);
	
	$('#srch_str').click(emptyInput);
	$('#login_usuario').click(emptyInput);
	$('#login_clave').click(emptyInput);
	$('#login_clave').keypress(on_enter);
	
	$('#registrarse_btn').click(showRegister);
	$('#envio_form_int').click(validContactInt);
	
	$('#srch_str').keypress(on_enter_search);
});

function showRegister(e)
{
	e.preventDefault();
	$('#registrarse').trigger('click');
}