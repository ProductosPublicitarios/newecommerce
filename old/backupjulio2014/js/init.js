$(document).ready(function() {
	$('.slider').cycle({
		fx: 'scrollHorz',
		prev: 'a.prev',
		next: 'a.next',
		pager:  '.btn-slide', 
		pagerAnchorBuilder: function(idx, slide) { 
			// return selector string for existing anchor 
			return '.btn-slide li:eq(' + idx + ') a'; 
		}   
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

	$("#visera,#reloj,#maletin,#reflec,#kit,#esme,#map").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'width'			:	600, 
		'height'		:	400,
		'type'			:	'iframe'
	});		
	
	$('#add_fav').click(addFav);
	$('#srch_send').click(validBuscar);
	$('#envio_cotizar').click(validContact);
	
	$('#srch_str').click(emptyInput);
	$('#login_usuario').click(emptyInput);
	$('#login_clave').click(emptyInput);
	
	$('#login_clave').keypress(on_enter);
	
	$('#srch_str').keypress(on_enter_search);
});




